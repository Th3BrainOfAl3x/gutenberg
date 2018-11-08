<?php
/**
 * Blocks API: WP_Block_Tree_Iterator class
 *
 * @package gutenberg
 * @since 4.4.0
 */

/**
 * Core class used for traversing a block tree
 *
 * @since 4.4.0
 */
class WP_Block_Tree_Iterator extends RecursiveFilterIterator {
	/**
	 * Determines if the current item is eligible for iteration
	 * Eligibility is based on whether the item is a non-whitespace-only block
	 *
	 * @return bool whether we can iterate over this item
	 */
	public function accept() {
		$this_block = $this->current();

		return is_array( $this_block ) && 0 === preg_match( '/^[\r\n]+$/', $this_block['innerHTML'] );
	}

	/**
	 * Returns the children needed to continue iteration.
	 * Returns a block's inner blocks.
	 *
	 * @return WP_Block_Tree_Iterator iterates over a block's inner blocks
	 */
	public function getChildren() {
		$this_block   = $this->current();
		$inner_blocks = $this_block['innerBlocks'];
		$rai          = new RecursiveArrayIterator( $inner_blocks );

		return new self( $rai );
	}

	/**
	 * Creates a new block tree iterator
	 *
	 * @param array $block_tree (coerced) array of blocks to traverse in a depth-first order.
	 * @return RecursiveIteratorIterator iterates over the given block or blocks.
	 */
	public static function create( $block_tree ) {
		$rai = new RecursiveArrayIterator( is_array( $block_tree ) ? $block_tree : array( $block_tree ) );
		$rfi = new WP_Block_Tree_Iterator( $rai );
		$rii = new RecursiveIteratorIterator( $rfi, RecursiveIteratorIterator::CHILD_FIRST );

		return $rii;
	}
}
