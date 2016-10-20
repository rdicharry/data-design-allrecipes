<?php

/**
 * An image associated with a recipe.
 *
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 * @version 0.0.1
 */
class Image {


	/**
	 * maximum allowed file length in the mySQL database.
	 */
	const IMAGE_FILE_LENGTH = 260;
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

	/**
	 * Construct a new Image with the specified id, image filename, and the id $imageRecipeId to associate it to a specified recipe.
	 * @param int|null $newImageId the id of this image or null if it is not yet entered in the database.
	 * @param string $imageFile the file name of the image.
	 * @param int $imageRecipeId the id of the recipe with which the image is associated.
	 * @throws \InvalidArgumentException if the inputs are invalid.
	 * @throws \RangeException if $newImgaeId or $newImageRecipeId are not positive, or if filename $newImageFile is too long.
	 * @throws \TypeError if the inputs do not match the requested types.
	 * @throws \Exception for other types of exceptions.
	 */
	public function __construct(int $newImageId, string $newImageFile, int $newImageRecipeId) {
		// rethrow exceptions to caller
		try {
			$this->setImageId($newImageId);
			$this->setImageFile($newImageFile);
			$this->setImageRecipeId($newImageRecipeId);
		} catch(\InvalidArgumentException $invalidArg) {
			throw(new \InvalidArgumentException($invalidArg->getMessage(), 0, $invalidArg));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $type) {
			throw(new \TypeError($type->getMessage(), 0, $type));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method for image id.
	 * @return int the integer image id value
	 */
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * Mutator method for imageid. Set a new value for the image id.
	 * @param int|null $newImageId new id value for the image.
	 * @throws \RangeException if the values is not positive
	 * @throws \TypeError if the provided input is not an integer.
	 */
	public function setImageId(int $newImageId) {
		// if the image id is null, this is a new image that has not yet been assigned a mysql id
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}

		// verify positive id
		if($newImageId <= 0) {
			throw(new \RangeException("image id should be positive"));
		}

		// store
		$this->imageId = $newImageId;
	}

	/**
	 * Accessor method for image file.
	 * @return string the file name associated with this image
	 */
	public function getImageFile() {
		return ($this->imageFile);
	}

	/**
	 * @param string $newImageFile a valid image file.
	 * @throws \InvalidArgumentException if $newImageFile is null, or not a valid image
	 * @throws \RangeException if file name exceeds maximum allowed (IMAGE_FILE_LENGTH)
	 */
	public function setImageFile(string $newImageFile) {
		// verify content
		$newImageFile = trim($newImageFile);
		$newImageFile = filter_var($newImageFile, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageFile) === true) {
			throw(new \InvalidArgumentException("invalid or empty image file name"));
		}
		// can we find the image file?
		if(!file_exists($newImageFile)) {
			throw(new \InvalidArgumentException("cound not find file with path: " . $newImageFile));
		}

		if(strlen($newImageFile) > self::IMAGE_FILE_LENGTH) {
			throw(new \RangeException("image file name exceeds " . self::IMAGE_FILE_LENGTH . " characters"));
		}

		// TODO upload image and construct local path

		$this->imageFile = $newImageFile;

	}

	/**
	 * Accessor method for image recipe id.
	 * @return int the id of the recipe associated with this image.
	 */
	public function getImageRecipeId() {
		return ($this->imageRecipeId);
	}

	/**
	 * The id of the recipe with which this image is associated.
	 * @param int $newRecipeId the id of a valid recipe with which this image is associated.
	 * @throws \InvalidArgumentException if the id is null or invalid value
	 * @throws \TypeError if the value is not an integer
	 * @throws \RangeException if the value is not positive
	 */
	public function setImageRecipeId(int $newRecipeId) {
		// require an id from the originating recipe
		if($newRecipeId === null) {
			throw(new \InvalidArgumentException("image must be associated with a valid recipe id"));
		}

		// verify positive
		if($newRecipeId <= 0) {
			throw(new \RangeException("recipe id should be positive"));
		}

		// store
		$this->imageRecipeId = $newRecipeId;

	}


}