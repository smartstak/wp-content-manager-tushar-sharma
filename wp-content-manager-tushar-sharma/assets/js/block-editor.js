import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	return (
		<div {...useBlockProps()}>
			Promo Blocks will render on frontend
		</div>
	);
}
