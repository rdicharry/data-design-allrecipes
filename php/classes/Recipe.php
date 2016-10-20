<?php

namespace Edu\Cnm\Rdicharry\DataDesignAllrecipes;

/**
 * Represents a single recipe.
 *
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 * @version 0.0.1
 */
class Recipe {

	/**
	 * A list of ingredients and amounts stored as a string.
	 *
	 * @var string $recipeIngredients
	 */
	// TODO would this be better as an associative array, or other structure
	private $recipeIngredients;

	/**
	 * Id of the Recipe; this is a primary key
	 * @var int $recipeId
	 */
	private $recipeId;

	/**
	 * Id of the user that created this recipe. This is a foreign key.
	 * @var int $recipeUserId
	 */
	private $recipeUserId;

	/**
	 * The number of minutes needed to prepare the ingredients (but not to cook them).
	 * @var int $recipePrepTime
	 */
	private $recipePrepTime;

	/**
	 * The number of minutes needed to cook the recipe (does not include prep)
	 * @var int $recipeCookTime
	 */
	private $recipeCookTime;

	/**
	 * Any additional notes to assist in recipe preparation.
	 * @var string $recipeFootnotes
	 */
	private $recipeFootnotes;

	/**
	 * A step-by-step description of how to prepare the recipe.
	 * @var string $recipeDirections
	 */
	// TODO might be represented as an array of strings?
	private $recipeDirections;

	public function __construct(string $newRecipeIngredients, int $newRecipeId, int $newRecipeUserId, int $newRecipePrepTime, int $newRecipeCookTime, string $newRecipeFootnotes) {
		// catch exceptions and rethrow to caller
		try {
			$this->setRecipeIngredients($newRecipeIngredients);
			$this->setRecipeId($newRecipeId);
			$this->setRecipeUserId($newRecipeUserId);
			$this->setRecipePrepTime($newRecipePrepTime);
			$this->setRecipeCookTime($newRecipeCookTime);
			$this->setRecipeFootnotes($newRecipeFootnotes);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
			throw(new \RangeException($rangeException->getMessage(), 0, $rangeException));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Accessor method for recipe ingredients
	 * @return string a list of the ingredients and amounts needed for the recipe
	 */
	public function getRecipeIngredients() {
		return ($this->recipeIngredients);
	}

	/**
	 * Accessor method for recipe id
	 * @return int value of recipe id
	 */
	public function getRecipeId() {
		return ($this->recipeId);
	}

	/**
	 * Accessor method for recipe user id
	 * @return int userId of the creator of this recipe
	 */
	public function getRecipeUserId() {
		return ($this->recipeUserId);
	}

	/**
	 * Accessor method for recipe prep time (time in minutes to prepare ingredients for cooking)
	 * @return int prep time in minutes or null if not prep time was specified by the user.
	 */
	public function getRecipePrepTime() {
		return ($this->recipePrepTime);
	}

	/**
	 * Accessor method for cook time
	 * @return int cook time in minutes
	 */
	public function getRecipeCookTime() {
		return ($this->recipeCookTime);
	}

	/**
	 * Accessor method for recipe footnotes
	 * @return string the footnotes for this recipe
	 */
	public function getRecipeFootnotes() {
		return ($this->recipeFootnotes);
	}

	/**
	 * mutator method for recipe ingredient content
	 *
	 * @param string $newRecipeIngredients the ingredients list associated with this recipe
	 * @throws \InvalidArgumentException if $newRecipeIngredients empty, invalid or unsafe
	 * @throws \RangeException if $newRecipeIngredients more than 5000 bytes.
	 * @throws \TypeError if $newRecipeIngredients is not a string
	 */
	public function setRecipeIngredients(string $newRecipeIngredients) {
		//verify ingredients content
		$newRecipeIngredients = trim($newRecipeIngredients);
		$newRecipeIngredients = filter_var($newRecipeIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeIngredients) === true) {
			throw(new \InvalidArgumentException("invalid or empty recipe ingredients"));
		}

		// verify ingredients content will fit int the database
		if(strlen($newRecipeIngredients) > 5000) {
			throw(new \RangeException("recipe ingredients content too large"));
		}

		// store the content
		$this->recipeIngredients = $newRecipeIngredients;
	}

	/**
	 * Mutator method for recipe id.
	 * @param int|null $newRecipeId value of the new recipe id.
	 * @throws \TypeError if the new recipe id is not an iteger
	 * @throws \RangeException if the new recipe id is not positive
	 */
	public function setRecipeId(int $newRecipeId = null) {
		// if recipe id is null, this is a new recipe that does not yet have a mysql assigned to it
		if($newRecipeId === null) {
			$this->recipeId = null;
			return;
		}

		// verify recipe id is positive
		if($newRecipeId <= 0) {
			throw(new \RangeException("recipe id should be positive"));
		}

		// store new recipe id
		$this->recipeId = $newRecipeId;

	}

	/**
	 * Mutator method for recipe user id. sets the user id associated with this recipe
	 * @param int $newRecipeUserId a positive integer user id (profile user id) number
	 * @throws \InvalidArgumentException if the id number is null
	 * @throws \RangeException if the value is not positive
	 */
	public function setRecipeUserId(int $newRecipeUserId) {
		// there should be a user id associated with this recipe
		if($newRecipeUserId === null) {
			throw(new \InvalidArgumentException("no specified user id"));
		}

		// verify the value is positive
		if($newRecipeUserId <= 0) {
			throw(new \RangeException("recipe user id should be positive"));
		}

		//store the new recipe user id
		$this->recipeUserId = $newRecipeUserId;
	}

	/**
	 *  Mutator method for $recipePrepTime. The amount of time in minutes to prepare (but not cook) the recipe.
	 * @param int|null $newPrepTime a positive integer prep time in minutes, or null if the prep time was not specified by the user.
	 * @throws \TypeError if the provided value is not an integer
	 * @throws \RangeException if the prep time is not positive
	 */
	public function setRecipePrepTime(int $newPrepTime) {
		// allow user to omit prep time, could be displayed as "-" for example
		if($newPrepTime === null) {
			$this->recipePrepTime = null;
			return;
		}

		// otherwise verify value is positive and store
		if($newPrepTime <= 0) {
			throw(new \RangeException("prep time should be positive"));
		}
		$this->recipePrepTime = $newPrepTime;

	}

	/**
	 * Mutator method for $recipeCookTime. The amount of time in minutes to cook the recipe (not including prep time.
	 * @param int|null $newCookTime a positive integer cook time in minutes or null if the cook time was not specified by the user.
	 * @throws \TypeError if the provided values is not an integer
	 * @throws \
	 */
	public function setRecipeCookTime(int $newCookTime) {
		// allow user to omit cook time, could be displayed as "-" for example
		if($newCookTime === null) {
			$this->recipeCookTime = null;
			return;
		}

		// otherwise verify value is positive and store
		if($newCookTime <= 0) {
			throw(new \RangeException("cook time should be positive"));
		}
		$this->recipeCookTime = $newCookTime;
	}


	/**
	 * Mutator method for $recipeFootnotes.
	 * @param string|null $newFootnotes the footnotes content string or null if not footnotes entered by user.
	 * @throws \TypeError if the provided input is not a string.
	 * @throws \InvalidArgumentException if the provided input rejected by filter sanitization.
	 * @throws \RangeException if the provided input is too long.
	 */
	public function setRecipeFootnotes(string $newFootnotes) {

		// allow null footnotes - user may choose to omit footnotes
		if($newFootnotes === null) {
			$this->recipeFootnotes = null;
		}

		// verify footnotes content
		$newFootnotes = trim($newFootnotes);
		$newFootnotes = filter_var($newFootnotes, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFootnotes) === true) {
			throw(new \InvalidArgumentException("invalid footnotes content"));
		}

		//verify content will fit in database
		if(strlen($newFootnotes) > 420) {
			throw(new \RangeException("footnotes content too large"));
		}

		// store content
		$this->recipeFootnotes = $newFootnotes;
	}

	/**
	 * Mutator method for $recipeDirections.
	 * @param string $newDirections user input for directions for making the recipe. Should not be null.
	 * @throws \TypeError if the input is not a string
	 * @throws \RangeException if the input is too long
	 * @throws \InvalidArgumentException if the directions empty or insecure
	 */
	public function setRecipeDirections(string $newDirections) {

		// verify valid input
		$newDirections = trim($newDirections);
		$newDirections = filter_var($newDirections, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newDirections) === true) {
			throw(new \InvalidArgumentException("recipe directions empty or insecure"));
		}

		// verify recipe directions will fit into database
		if(strlen($newDirections) > 10000) {
			throw(new \RangeException("recipe directions content too large"));
		}

		// store directions
		$this->recipeDirections = $newDirections;

	}
}