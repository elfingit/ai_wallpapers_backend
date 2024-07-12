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
    case ALL = '*';
    case ADD_FILE_TO_GALLERY = 'add:gallery';
    case EDIT_FILE_IN_GALLERY = 'edit:gallery';
    case UPDATE_FILE_IN_GALLERY = 'upd:gallery';
    case INDEX_OF_GALLERY = 'lst:gallery';
    case INDEX_OF_GALLERY_BY_DEVICES = 'lst:gallery:devices';
    case INDEX_OF_GALLERY_BY_USERS = 'lst:gallery:users';
    case DELETE_FILE_FROM_GALLERY = 'del:gallery';
    case REFRESH_PIC_GALLERY = 'refresh:gallery';
    case THUMBNAIL_OF_PICTURE = 'pic:thumb';
    case PICTURE_PROMPT = 'pic:prompt';
    case ADD_TAG = 'add:tag';

    case MAIN_BALANCE = 'balance:main';

    case MAKE_WALLPAPER = 'make:wallpaper';

    case LOGOUT = 'logout';

    case USER_LIST = 'user:list';

    case PICTURE_LOCALE = 'pic:locale';

    case BILLING_PURCHASE = 'billing:purchase';

    case DELETE_SELF_ACCOUNT = 'del_self:account';

    case ADD_CATEGORY = 'add:category';
    case EDIT_CATEGORY = 'edit:category';
    case UPDATE_CATEGORY = 'update:category';
    case LIST_CATEGORY = 'list:category';
    case META_CATEGORY = 'meta:category';

    case MAIN_INDEX = 'main:index';
    case MAIN_PROFILE = 'main:profile';
    case ADMIN_DASHBOARD = 'admin:dashboard';

    public function value(): string
    {
        return $this->value;
    }
}
