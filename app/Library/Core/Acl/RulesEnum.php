<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 24.01.24
 * Time: 15:18
 */

namespace App\Library\Core\Acl;

enum RulesEnum : string
{
    case ADD_FILE_TO_GALLERY = 'add:gallery';
    case EDIT_FILE_IN_GALLERY = 'edit:gallery';
    case UPDATE_FILE_IN_GALLERY = 'upd:gallery';
    case INDEX_OF_GALLERY = 'lst:gallery';
    case THUMBNAIL_OF_PICTURE = 'pic:thumb';
    case PICTURE_PROMPT = 'pic:prompt';
    case ADD_TAG = 'add:tag';

    public function value(): string
    {
        return $this->value;
    }
}
