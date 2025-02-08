import { useBlockProps, RichText } from '@wordpress/block-editor';

function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	const saveAttributes = (propertyName, newValue ) => {
		setAttributes( { [propertyName]: newValue } );
	};

	return (
		<div {...blockProps}>
			<RichText
				tagName="h1"
				placeholder="Enter heading"
				value={ attributes.heading }
				onChange={ e => saveAttributes( 'heading', e ) }
			/>
			<RichText
				tagName="p"
				placeholder="Enter sub-heading"
				value={ attributes.sub_heading }
				onChange={ e => saveAttributes( 'sub_heading', e ) }
			/>
		</div>
	);
}

export default Edit;
