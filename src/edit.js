/**
 * Retrieves the translation of text.
 */
import { __ } from '@wordpress/i18n';

import { useBlockProps } from '@wordpress/block-editor';

/**
 * Editor css.
 */
import './editor.scss';

/**
 * Edit.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit() {
	return (
		<p { ...useBlockProps() }>
			{ __( 'Shows selected primary category', 'primary-category' ) }
		</p>
	);
}
