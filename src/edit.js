/**
 * Retrieves the translation of text.
 */
import { __ } from '@wordpress/i18n';

import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Editor css.
 */
import './editor.scss';

/**
 * Edit.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	return (
		<p { ...useBlockProps() }>
			{ __( 'Shows selected primary category', 'primary-category' ) }
			<ServerSideRender
                block="ivdimova/primary-category"
                attributes={ props }
            />
		</p>
	);
}
