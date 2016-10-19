<?php
namespace Edu\Cnm\Rdicharry\DataDesignAllrecipes;

/**
 * A Profile for an Allrecipes account.
 *
 * @author Rebecca Dicharry <rdicharry@cnm.edu>
 * @version 0.0.1
 */
class Profile {

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
	 * @throws \Exception
	 * @throws \TypeError
	 */
	public function __construct(int $newProfileUserId, string $newProfileEmail, string $newProfileAvatarImage) {

		try {
			$this->setProfileUserId($newProfileUserId);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileAvatarImage($newProfileAvatarImage);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
			// catch(\RangeException $rangeException) {
			//	throw(new \RangeExcpetion($range->getMessage(), 0, $range));
			//}
		catch(\TypeError $typeError) {

			throw(new \TypeError($typeError->getMessage(), 0, $typeError));

		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}

	}

	/*
	 *
	 */
	public function getProfileUserId() {
		return ($this->profileUserId);
	}

	public function setProfileUserId(int $newProfileUserId) {
		$this->$profileUserId = $newProfileUserId;
	}


}