import { useBlockProps, RichText } from '@wordpress/block-editor';

function Save( { attributes } ) {
	const blockProps = useBlockProps.save();

	return (
		<div {...blockProps}>
			<RichText.Content value={attributes.heading} tagName="h1" />
			<RichText.Content value={attributes.sub_heading} tagName="p" />
		</div>
	);
}

export default Save;
