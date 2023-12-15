module.exports = {
    extends: ['stylelint-config-standard-scss'],
    plugins: ['stylelint-scss'],
    rules: {
        "indentation": "tab",
        "no-duplicate-selectors": false,
        "color-hex-case": "lower",
        "color-no-hex": false,
        "selector-no-qualifying-type": false,
        "selector-combinator-space-after": "always",
        "selector-attribute-quotes": "always",
        "selector-attribute-operator-space-before": "never",
        "selector-attribute-operator-space-after": "never",
        "selector-attribute-brackets-space-inside": "never",
        "declaration-block-trailing-semicolon": "always",
        "declaration-colon-space-before": "never",
        "declaration-colon-space-after": "always",
        "function-url-quotes": "always",
        "rule-empty-line-before": "always-multi-line",
        "selector-pseudo-class-parentheses-space-inside": "never",
        "media-feature-range-operator-space-before": "always",
        "media-feature-range-operator-space-after": "always",
        "media-feature-parentheses-space-inside": "never",
        "media-feature-colon-space-before": "never",
        "media-feature-colon-space-after": "always"
    }
}