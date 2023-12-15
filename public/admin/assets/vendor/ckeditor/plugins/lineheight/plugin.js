( function() {
	function addCombo( editor, comboName, styleType, lang, entries, defaultLabel, styleDefinition, order ) {
		var config = editor.config,style = new CKEDITOR.style( styleDefinition );
		var names = entries.split( ';' ),values = [];
		var styles = {};
		for ( var i = 0; i < names.length; i++ ) {
			var parts = names[ i ];
			if ( parts ) {
				parts = parts.split( '/' );
				var vars = {},name = names[ i ] = parts[ 0 ];
				vars[ styleType ] = values[ i ] = parts[ 1 ] || name;
				//console.log(names[ i ]);
				styles[ name ] = new CKEDITOR.style( styleDefinition, vars );
				styles[ name ]._.definition.name = name;
			} else
				names.splice( i--, 1 );
		}
		editor.ui.addRichCombo( comboName, {
			label: editor.lang.lineheight.title,
			title: editor.lang.lineheight.title,
			toolbar: 'styles,' + order,
			allowedContent: style,
			requiredContent: style,
			panel: {
				css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
				multiSelect: false,
				attributes: { 'aria-label': editor.lang.lineheight.title }
			},
			init: function() {
				this.startGroup(editor.lang.lineheight.title);
				for ( var i = 0; i < names.length; i++ ) {
					var name = names[ i ];
					this.add( name, name, name );
				}
			},
			onClick: function( value ) {
				editor.focus();
				editor.fire( 'saveSnapshot' );
				var style = styles[ value ];
				editor[ this.getValue() == value ? 'removeStyle' : 'applyStyle' ]( style );
				editor.fire( 'saveSnapshot' );
			},
			onRender: function() {
				editor.on( 'selectionChange', function( ev ) {
					var currentValue = this.getValue();
					var elementPath = ev.data.path,elements = elementPath.elements;
					for ( var i = 0, element; i < elements.length; i++ ) {
						element = elements[ i ];
						for ( var value in styles ) {
							if ( styles[ value ].checkElementMatch( element, true, editor ) ) {
								if ( value != currentValue )
									this.setValue( value );
								return;
							}
						}
					}
					this.setValue( '', defaultLabel );
				}, this );
			},
			refresh: function() {
				if ( !editor.activeFilter.check( style ) )
					this.setState( CKEDITOR.TRISTATE_DISABLED );
			}
		} );
	}
	CKEDITOR.plugins.add( 'lineheight', {
		requires: 'richcombo',
		lang: 'ar,de,en,es,fr,ko,pt',
		init: function( editor ) {
			var config = editor.config;
			addCombo( editor, 'lineheight', 'size', editor.lang.lineheight.title, config.line_height, editor.lang.lineheight.title, config.lineHeight_style, 40 );
		}
	} );
} )();
CKEDITOR.config.line_height = '5px;6px;7px;8px;9px;10px;11px;12px;13px;14px;15px;16px;17px;18px;19px;20px;21px;22px;23px;24px;25px;26px;27px;28px;29px;30px;31px;32px;33px;34px;35px;36px;37px;38px;39px;40px;41px;42px;43px;44px;45px;46px;47px;48px;49px;50px;51px;52px;53px;54px;55px;56px;57px;58px;59px;60px;61px;62px;63px;64px;65px;66px;67px;68px;69px;70px;71px;72px';
CKEDITOR.config.lineHeight_style = {
	element: 'span',
	styles: { 'line-height': '#(size)' },
	overrides: [ {
		element: 'line-height', attributes: { 'size': null }
	} ]
};
