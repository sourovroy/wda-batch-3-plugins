import { registerBlockType } from '@wordpress/blocks';

import Edit from './Edit';
import Save from './Save';

import metadata from './block.json';

registerBlockType( metadata, {
	edit: Edit,
	save: Save,
} );
