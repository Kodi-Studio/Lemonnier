/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	BlockControls,
	AlignmentToolbar,
	InspectorControls,
	ColorPalette,
} from "@wordpress/block-editor";
import { Button, PanelBody } from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
//  */
// export default function Edit() {
// 	return (
// 		<p { ...useBlockProps() }>
// 			{ __(
// 				'Travel Card Block – hello from the editor!',
// 				'travel-card-block'
// 			) }
// 		</p>
// 	);
// }

export default function Edit({ attributes, setAttributes }) {
	const {
		title,
		content,
		mediaID,
		mediaURL,
		alignment,
		backgroundColor,
		titleTextColor,
		otherTextColor,
		borderColor,
	} = attributes;

	const onChangeTitle = (newTitle) => {
		setAttributes({ title: newTitle });
	};

	const onChangeContent = (newContent) => {
		setAttributes({ content: newContent });
	};

	const onSelectImage = (media) => {
		setAttributes({
			mediaURL: media.url,
			mediaID: media.id,
		});
	};

	const onChangeAlignment = (newAlignment) => {
		setAttributes({
			alignment: newAlignment === undefined ? "none" : newAlignment,
		});
	};

	const onChangeBackgroundColor = (newBackgroundColor) => {
		setAttributes({ backgroundColor: newBackgroundColor });
	};

	const onChangeTitleTextColor = (newTitleTextColor) => {
		setAttributes({ titleTextColor: newTitleTextColor });
	};

	const onChangeOtherTextColor = (newOtherTextColor) => {
		setAttributes({ otherTextColor: newOtherTextColor });
	};

	const onChangeBorderColor = (newBorderColor) => {
		setAttributes({ borderColor: newBorderColor });
	};

	return (
		<div
			className="travel-block"
			{...useBlockProps({ style: { backgroundColor, borderColor } })}
		>
			<InspectorControls>
				<PanelBody title={__("Couleur de fond", "travel-card-block")}>
					<ColorPalette
						value={backgroundColor}
						onChange={onChangeBackgroundColor}
					/>
				</PanelBody>
				<PanelBody title={__("Couleur du titre", "travel-card-block")}>
					<ColorPalette
						value={titleTextColor}
						onChange={onChangeTitleTextColor}
					/>
				</PanelBody>
				<PanelBody title={__("Couleur du texte", "travel-card-block")}>
					<ColorPalette
						value={otherTextColor}
						onChange={onChangeOtherTextColor}
					/>
				</PanelBody>
				<PanelBody title={__("Couleur de contour", "travel-card-block")}>
					<ColorPalette value={borderColor} onChange={onChangeBorderColor} />
				</PanelBody>
				alignment
			</InspectorControls>
			<BlockControls>
				<AlignmentToolbar value={alignment} onChange={onChangeAlignment} />
			</BlockControls>
			<MediaUploadCheck>
				<MediaUpload
					onSelect={onSelectImage}
					allowedTypes="image"
					value={mediaID}
					render={({ open }) => (
						<Button
							onClick={open}
							className={mediaID ? "image-button" : "button button-large"}
						>
							{mediaID ? (
								<img src={mediaURL} alt="" />
							) : (
								__("Upload Image", "travel-card-block")
							)}
						</Button>
					)}
				/>
			</MediaUploadCheck>
			<RichText
				tagName="h2"
				onChange={onChangeTitle}
				value={title}
				placeholder={__("Votre titre ici", "my-custom-block")}
				style={{ textAlign: alignment, color: titleTextColor }}
			/>
			<RichText
				tagName="p"
				onChange={onChangeContent}
				value={content}
				placeholder={__(
					"Ici votre texte et texte description",
					"travel-card-block",
				)}
				style={{ textAlign: alignment, color: otherTextColor }}
			/>
		</div>
	);
}
