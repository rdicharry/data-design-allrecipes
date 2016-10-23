<?php
namespace Edu\Cnm\Rdicharry\DataDesignAllrecipes;

/**
 * A Profile for an Allrecipes account.
 *
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 * @version 0.0.1
 */
class Profile {


	/**
	 * maximum allowed file length in the mySQL database.
	 */
	const IMAGE_FILE_LENGTH = 260;
	/*
	 * Id for the profile, this is the primary key.
	 * @var int $profileUserId
	 */
	private $profileUserId;

	/*
	 * The email associated with this user account.
	 * @var string $profileEmail
	 */
	private $profileEmail;

	/*
	 * An avatar image to represent this user.
	 * @var string $profileAvatarImage
	 */
	private $profileAvatarImage;

	/**
	 * Profile constructor.
	 * @param int $newProfileUserId
	 * @param string $newProfileEmail
	 * @param string $newProfileAvatarImage
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 * @throws \TypeError
	 * @throws \RangeException
	 * @throws \UnexpectedValueException
	 */
	public function __construct(int $newProfileUserId, string $newProfileEmail, string $newProfileAvatarImage) {

		// rethrow exceptions to the caller
		try {
			$this->setProfileUserId($newProfileUserId);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileAvatarImage($newProfileAvatarImage);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
			throw(new \RangeException($rangeException->getMessage(), 0, $rangeException));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\UnexpectedValueException $unexpectedValueException) {
			throw(new \UnexpectedValueException($unexpectedValueException->getMessage(), 0, $unexpectedValueException));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}

	}

	/*
	 * accessor method for profile user id
	 *@return int|null values of profile user id
	 */
	public function getProfileUserId() {
		return ($this->profileUserId);
	}

	/*
	 * accessor method for profile email
	 * @return string containing profile's email address
	 */
	public function getProfileEmail() {
		return ($this->profileEmail);
	}

	/**
	 * accessor method for profile avatar image
	 * @return string values of image path
	 */
	public function getProfileAvatarImage() {
		return ($this->profileAvatarImage);
	}

	/**
	 * Set the user Id for this profile. Input is validated (should be a positive integer).
	 * Note: a TypeError exception will be thrown if the input is not an integer (or null).
	 * @param int $newProfileUserId
	 * @throws \UnexpectedValueException if
	 */
	public function setProfileUserId(int $newProfileUserId = null) {

		// if the profile user id is null, this is a new profile that does not yet have a mysql assigned id.
		if($newProfileUserId === null) {
			$this->profileUserId = null;
			return;
		}

		// verify the user id is valid
		if($newProfileUserId <= 0) {
			throw(new \RangeException("profile user id should be positive"));
		}

		$this->profileUserId = $newProfileUserId;

	}

	/**
	 * Set the email address accociated with this profile.
	 * @param string $newProfileEmail a valid email address associated with this profile
	 * @throws \RangeException if the email address is too long
	 * @throws \InvalidArgumentException if the email is invalid or empty
	 */
	public function setProfileEmail(string $newProfileEmail) {
		// sanatize email input
		// note: additional email validation can be provided by requiring the user to manually validate the email before the account becomes active.
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("invalid or empty email provided"));
		}

		// verify email values will fit into database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("email address too long"));
		}

		// store email
		$this->profileEmail = $newProfileEmail;

	}

	/**
	 * Set the image file associated with this profile.
	 * @param string $newProfileAvatarImage file name of avatar image
	 * @throws \InvalidArgumentException if file name is empty or invalid
	 * @throws \RangeException if file size exceeds maximum allowed in database (IMAGE_FILE_LENGTH)
	 */
	public function setProfileAvatarImage(string $newProfileAvatarImage) {
		// sanatize input
		$newProfileAvatarImage = trim($newProfileAvatarImage);
		$newProfileAvatarImage = filter_var($newProfileAvatarImage, FILTER_SANITIZE_STRING);
		if(empty($newProfileAvatarImage) === true) {
			throw(new \InvalidArgumentException("invalid or empty avatar image file name"));
		}
		// can we find the image file?
		if(!file_exists($newProfileAvatarImage)) {
			throw(new \InvalidArgumentException("cound not find file with path: " . $newProfileAvatarImage));
		}

		//TODO upload image and construct local path

		if(strlen($newProfileAvatarImage > self::IMAGE_FILE_LENGTH)) {
			throw(new \RangeException("image file name exceeds " . self::IMAGE_FILE_LENGTH . " characters"));
		}
		//store local path
		$this->profileAvatarImage = $newProfileAvatarImage;

	}

	/**
	 * Inserts this profile into mySQL.
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException if there is a mySQL related error.
	 * @throws \TypeError if $pdo is not a PDO connecton object.
	 */
	public function insert(\PDO $pdo) {
		// enforce this profileId is not null - do not insert a profile that already exists
		if($this->profileUserId === null) {
			throw(new \PDOException("profileUserId already exists, cannot insert into database"));
		}

		// create query template
		$query = "INSERT INTO profile(profileUserId, profileEmail, profileAvatarImage) VALUES (:profileUserId, :profileEmail, :profileAvatarImage)";
		$statement = $pdo->prepare($query);

		// bind member variables to placeholders in the template
		$parameters = ["profileUserId" => $this->profileUserId, "profileEmail" => $this->profileEmail, "profileAvatarImage" => $this->profileAvatarImage];
		$statement->execute($parameters);

		// get newly created profileUserId, and update into this object
		$this->profileUserId = intval($pdo->lastInsertId());

	}

	/**
	 * Deletes this profile from mySQL.
	 * @param \PDO $pdo PDO connection object.
	 * @throws \PDOException when mySQL related error occur.
	 * @throws \TypeError if $pdo is not a PDO connection object.
	 */
	public function delete(\PDO $pdo) {
		// enforce this profileUserId is not null (don't delete a non-existent profile)
		if($this->profileUserId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}

		//create query template
		$query = "DELETE FROM profile WHERE profileUserId = :profileUserId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["profileUserId" => $this->profileUserId];
		$statement->execute($parameters);
	}

	/**
	 * Update this Profile in mySQL.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		// check that the profileUserId is not null - do not update a profile that has not been inserted.
		if($this->profileUserId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}

		// create query template
		$query = "UPDATE profile SET profileEmail=:profileEmail, profileAvatarImage =:profileAvatarImage WHERE profileUserId =:profileUserId";
		$statement = $pdo->prepare($query);

		// bind parameters to member variables
		$parameters = ["profileEmail" => $this->profileEmail, "profileAvatarImage" => $this->profileAvatarImage, "profileUserId" => $this->profileUserId];

		// execute statement
		$statement->execute($parameters);
	}


}