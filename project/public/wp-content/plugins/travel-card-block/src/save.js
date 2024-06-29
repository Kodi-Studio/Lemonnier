/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from "@wordpress/block-editor";

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
// export default function save() {
// 	return (
// 		<p { ...useBlockProps.save() }>
// 			{ 'Travel Card Block – hello from the saved content!' }
// 		</p>
// 	);
// }

export default function save({ attributes }) {
	const {
		title,
		content,
		mediaURL,
		alignment,
		backgroundColor,
		titleTextColor,
		otherTextColor,
		borderColor,
	} = attributes;

	return (
		<div
			className="travel-block"
			style={{ borderColor: borderColor }}
			{...useBlockProps.save({ style: { backgroundColor, borderColor } })}
		>
			{mediaURL && <img src={mediaURL} alt="" />}
			<RichText.Content
				tagName="h2"
				value={title}
				style={{ textAlign: alignment, color: titleTextColor }}
			/>
			<RichText.Content
				tagName="p"
				value={content}
				style={{ textAlign: alignment, color: otherTextColor }}
			/>
		</div>
	);
}
