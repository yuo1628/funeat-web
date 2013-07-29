<?php

namespace models;

use models\entity\image\Images as Images;
use models\model\ORMModel as Model;

/**
 * Image model
 *
 * @category		models
 * @author			Miles <jangconan@gmail.com>
 * @version			1.0
 */
class Image extends Model
{
	/**
	 * Constructor.
	 */
	public function __construct($entity = "models\\entity\\image\\Images")
	{
		parent::__construct($entity);
	}

	/**
	 * Upload image files
	 *
	 * @param		MY_Upload $upload
	 * @param		models\entity\member\Members $creator
	 * @param		string $name
	 * @param		boolean $multiple
	 *
	 * @return		mixed Images instance or array when multiple
	 */
	public function upload($upload, $creator, $name, $multiple = false)
	{
		$upload->initialize(Images::$UPLOAD_CONFIG);

		/**
		 * @var models\entity\image\Images
		 */
		$image = null;

		if ($multiple)
		{
			if ($upload->do_multi_upload($name))
			{
				$files = $upload->get_multi_upload_data();

				$image = array();

				foreach ($files as $file)
				{
					if ($file['is_image'])
					{
						/**
						 * @var models\entity\image\Images
						 */
						$newImage = $this->getInstance();
						$newImage->setFile($file['orig_name'], $file['file_name']);
						$newImage->setCreater($creator);

						$image[] = $newImage;
					}
					else
					{
						delete_files($file['full_path']);
					}
				}
			}
		}
		else
		{
			if ($upload->do_upload($name))
			{
				$file = $upload->data();

				if ($file['is_image'])
				{
					/**
					 * @var models\entity\image\Images
					 */
					$image = $this->getInstance();
					$image->setFile($file['orig_name'], $file['file_name']);
					$image->setCreater($creator);
				}
				else
				{
					delete_files($file['full_path']);
				}
			}
		}

		return $image;
	}

}
