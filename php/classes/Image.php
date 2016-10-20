<?php

/**
 * An image associated with a recipe.
 *
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 * @version 0.0.1
 */
class Image {

	/**
	 * id for this image, this is the primary key
	 * @var int imageId
	 */
	private $imageId;

	/**
	 * filename for this image
	 * @var string $imageFile
	 */
	private $imageFile;

	/**
	 * the id of the recipe with which we would like to associate this image (foreign key)
	 * @var int $imageRecipeId
	 */
	private $imageRecipeId;


}