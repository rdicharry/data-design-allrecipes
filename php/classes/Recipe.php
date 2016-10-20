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
	 * id of the Recipe; this is a primary key
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

	// TODO constructor goes here
	/**
	 * accessor method for recipe ingredients
	 * @return string a list of the ingredients and amounts needed for the recipe
	 */
	public function getRecipeIngredients() {
		return ($this->recipeIngredients);
	}

	/**
	 * accessor method for recipe id
	 * @return int value of recipe id
	 */
	public function getRecipeId() {
		return ($this->recipeId);
	}

	/**
	 * accessor method for recipe user id
	 * @return int userId of the creator of this recipe
	 */
	public function getRecipeUserId() {
		return ($this->recipeUserId);
	}

	/**
	 * accessor method for recipe prep time (time in minutes to prepare ingredients for cooking)
	 * @return int prep time in minutes
	 */
	public function getRecipePrepTime() {
		return ($this->recipePrepTime);
	}

	/**
	 *accessor method for cook time
	 * @return int cook time in minutes
	 */
	public function getRecipeCookTime() {
		return ($this->recipeCookTime);
	}

	/**
	 * accessor method for recipe footnotes
	 * @return string the footnotes for this recipe
	 */
	public function getRecipeFootnotes() {
		return ($this->recipeFootnotes);
	}

	/**
	 * mutator method for recipe ingredient content
	 *
	 * @param string $newRecipeIngredients the ingredients list associated with this recipe
	 * @throws \InvalidArgumentExcpetion if $newRecipeIngredients empty, invalid or unsafe
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

	public function setRecipeId(int $newRecipeId = null) {
		// if recipe id is null, this is a new recipe that does not yet have a mysql assigned to it
		if($newRecipeId === null) {
			$this->recipeId = null;
			return;
		}

		// verify recipe id is positive
		if($newRecipeId <= 0) {

		}

	}

}