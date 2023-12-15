<?php

namespace Deployer;

require 'recipe/laravel.php';

set('application', 'Migoda');
set('repository', 'git@github.com:pars-design/migoda.git');
set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', [
    '.env'
]);
set('shared_dirs', [
    'storage'
]);

// Writable dirs by web server
set('writable_dirs', [
    'storage',
    'bootstrap/cache'
]);

// Set Laravel version
set('laravel_version', function () {
    $result = run('{{bin/php}} {{release_path}}/artisan --version');
    preg_match_all('/(\d+\.?)+/', $result, $matches);
    $version = $matches[0][0] ?? 5.5;
    return $version;
});

// Set the worker process user
set('http_user', 'worker');

// Set the default deploy environment to production
set('default_stage', 'beta');

// Disable multiplexing
set('ssh_multiplexing', false);

// Helper Tasks

desc('Disable maintenance mode');
task('artisan:up', function () {
    $output = run('if [ -f {{deploy_path}}/current/artisan ]; then {{bin/php}} {{deploy_path}}/current/artisan up; fi');
    writeln('<info>' . $output . '</info>');
});

desc('Enable maintenance mode');
task('artisan:down', function () {
    $output = run('if [ -f {{deploy_path}}/current/artisan ]; then {{bin/php}} {{deploy_path}}/current/artisan down; fi');
    writeln('<info>' . $output . '</info>');
});

desc('Execute artisan migrate');
task('artisan:migrate', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate --force');
})->once();

desc('Execute artisan migrate:fresh');
task('artisan:migrate:fresh', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:fresh --force');
})->once();

desc('Execute artisan migrate:rollback');
task('artisan:migrate:rollback', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan migrate:rollback --force');
    writeln('<info>' . $output . '</info>');
})->once();

desc('Execute artisan migrate:status');
task('artisan:migrate:status', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan migrate:status');
    writeln('<info>' . $output . '</info>');
})->once();

desc('Execute artisan db:seed');
task('artisan:db:seed', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan db:seed --force');
    writeln('<info>' . $output . '</info>');
})->once();

desc('Execute artisan migrate:fresh --seed');
task('artisan:migrate:fresh:seed', function () {
    $output = run('{{bin/php}} {{release_path}}/artisan migrate:fresh --seed');
    writeln('<info>' . $output . '</info>');
})->once();

desc('Execute artisan cache:clear');
task('artisan:cache:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan cache:clear');
});

desc('Execute artisan config:cache');
task('artisan:config:cache', function () {
    run('{{bin/php}} {{release_path}}/artisan config:cache');
});

desc('Execute artisan route:cache');
task('artisan:route:cache', function () {
    run('{{bin/php}} {{release_path}}/artisan route:cache');
});

desc('Execute artisan view:clear');
task('artisan:view:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan view:clear');
});

desc('Execute artisan optimize');
task('artisan:optimize', function () {
    $deprecatedVersion = 5.5;
    $currentVersion = get('laravel_version');
    if (version_compare($currentVersion, $deprecatedVersion, '<')) {
        run('{{bin/php}} {{release_path}}/artisan optimize');
    }
});

desc('Execute artisan queue:restart');
task('artisan:queue:restart', function () {
    run('{{bin/php}} {{release_path}}/artisan queue:restart');
});

desc('Execute artisan storage:link');
task('artisan:storage:link', function () {
    $needsVersion = 5.3;
    $currentVersion = get('laravel_version');
    if (version_compare($currentVersion, $needsVersion, '>=')) {
        run('{{bin/php}} {{release_path}}/artisan storage:link');
    }
});

desc('Make symlink for public disk');
task('deploy:public_disk', function () {
    // Remove from source.
    run('if [ -d $(echo {{release_path}}/public/storage) ]; then rm -rf {{release_path}}/public/storage; fi');
    // Create shared dir if it does not exist.
    run('mkdir -p {{deploy_path}}/shared/storage/app/public');
    // Symlink shared dir to release dir
    run('{{bin/symlink}} {{deploy_path}}/shared/storage/app/public {{release_path}}/public/storage');
});

// Tasks

// Upload build assets
task('upload', function () {
    upload(__DIR__ . "/public/admin/assets/", '{{release_path}}/public/admin/assets/');
    upload(__DIR__ . "/public/front/assets/", '{{release_path}}/public/front/assets/');
    upload(__DIR__ . "/public/css/", '{{release_path}}/public/css/');
    upload(__DIR__ . "/public/fonts/", '{{release_path}}/public/fonts/');
    upload(__DIR__ . "/public/images/", '{{release_path}}/public/images/');
    upload(__DIR__ . "/public/pdf/", '{{release_path}}/public/pdf/');
    upload(__DIR__ . "/public/mailing/", '{{release_path}}/public/mailing/');
    upload(__DIR__ . "/public/mix-manifest.json", '{{release_path}}/public/mix-manifest.json');
});

// Hosts

// Production Server(s)
host('migoda.com')
    ->hostname('migoda.com')
    ->user('migodacom')
    ->stage('production')
    ->set('deploy_path', '/var/www/vhosts/migoda.com/www')
    ->set('branch', 'production');

// Development/Staging Server
host('beta.migoda.com')
    ->hostname('migoda.com')
    ->user('migodacom')
    ->stage('beta')
    ->set('deploy_path', '/var/www/vhosts/migoda.com/beta.migoda.com')
    ->set('branch', 'master')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// Beta2
host('beta2.migoda.com')
    ->hostname('migoda.com')
    ->user('migodacom')
    ->stage('beta2')
    ->set('deploy_path', '/var/www/vhosts/migoda.com/beta2.migoda.com')
    ->set('branch', 'beta2')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

// Group tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'upload',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] Run migrations
after('deploy:vendors', 'artisan:migrate');

// [Optional] If deploy fails automatically unlock
after('deploy:failed', 'deploy:unlock');
