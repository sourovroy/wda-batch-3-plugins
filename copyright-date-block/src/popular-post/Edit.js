import { useBlockProps, RichText, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';

import { PanelBody, Toolbar, ToolbarButton, ToolbarGroup } from '@wordpress/components';
import { alignLeft, alignCenter, alignRight } from '@wordpress/icons';

function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	const onValueChange = (newValue) => {
		setAttributes( { heading: newValue } );
	};

	const [items, setItems] = useState([]);

	useEffect(() => {
		let url = ajaxurl + "?action=get_popular_post_items";
		fetch( url ).then(response => response.json()).then((response) => {
			setItems(response);
		});
	}, []);

	const onAlignmentChange = ( value ) => {
		setAttributes( { headingAlign: value } );
	};

	return (<div {...blockProps}>
		<InspectorControls>
			<PanelBody title="Settings">

			</PanelBody>
		</InspectorControls>

		<BlockControls group="other">
			<ToolbarGroup>
				<Toolbar label="Options">
					<ToolbarButton icon={ alignLeft } label="Left" onClick={() => onAlignmentChange('left')} />
					<ToolbarButton icon={ alignCenter } label="Center" onClick={() => onAlignmentChange('center')} />
					<ToolbarButton icon={ alignRight } label="Right" onClick={() => onAlignmentChange('right')} />
				</Toolbar>
			</ToolbarGroup>
		</BlockControls>

		<RichText
			tagName="h2"
			value={attributes.heading}
			onChange={onValueChange} style={{textAlign: attributes.headingAlign}}
		/>

		{items.map(item => (
			<h4>{item.post_title}</h4>
		))}
	</div>);
}

export default Edit;
