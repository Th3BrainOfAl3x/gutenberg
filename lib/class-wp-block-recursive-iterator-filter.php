<?php
/**
 * Blocks API: WP_Block_Recursive_Iterator_Filter class
 *
 * @package gutenberg
 * @since 4.4.0
 */

/**
 * Core class used for traversing a block tree
 *
 * @since 4.4.0
 */
class WP_Block_Recursive_Iterator_Filter extends RecursiveFilterIterator {
	/**
	 * Determines if the current item is eligible for iteration
	 * Eligibility is based on whether the item is an array of blocks
	 *
	 * @return bool whether we can iterate over this item
	 */
	public function accept() {
		$this_block = $this->current();

		return is_array( $this_block );
	}

	/**
	 * Returns the children needed to continue iteration.
	 * Returns a block's inner blocks.
	 *
	 * @return WP_Block_Recursive_Iterator_Filter iterates over a block's inner blocks
	 */
	public function getChildren() {
		$this_block   = $this->current();
		$inner_blocks = $this_block['innerBlocks'];
		$rai          = new RecursiveArrayIterator( $inner_blocks );

		return new self( $rai );
	}
}
