<?php

namespace Softspring\ImageBundle;

class SfsImageEvents
{
    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_LIST_INITIALIZE = 'sfs_image.admin.types.list_initialize';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_TYPES_LIST_VIEW = 'sfs_image.admin.types.list_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_CREATE_INITIALIZE = 'sfs_image.admin.types.create_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_CREATE_FORM_VALID = 'sfs_image.admin.types.create_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_CREATE_SUCCESS = 'sfs_image.admin.types.create_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_CREATE_FORM_INVALID = 'sfs_image.admin.types.create_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_TYPES_CREATE_VIEW = 'sfs_image.admin.types.create_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_UPDATE_INITIALIZE = 'sfs_image.admin.types.update_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_UPDATE_FORM_VALID = 'sfs_image.admin.types.update_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_UPDATE_SUCCESS = 'sfs_image.admin.types.update_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_UPDATE_FORM_INVALID = 'sfs_image.admin.types.update_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_TYPES_UPDATE_VIEW = 'sfs_image.admin.types.update_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_DELETE_INITIALIZE = 'sfs_image.admin.types.delete_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_DELETE_FORM_VALID = 'sfs_image.admin.types.delete_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_DELETE_SUCCESS = 'sfs_image.admin.types.delete_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_TYPES_DELETE_FORM_INVALID = 'sfs_image.admin.types.delete_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_TYPES_DELETE_VIEW = 'sfs_image.admin.types.delete_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_TYPES_READ_INITIALIZE = 'sfs_image.admin.types.read_initialize';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_TYPES_READ_VIEW = 'sfs_image.admin.types.read_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_LIST_INITIALIZE = 'sfs_image.admin.images.list_initialize';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_IMAGES_LIST_VIEW = 'sfs_image.admin.images.list_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_CREATE_INITIALIZE = 'sfs_image.admin.images.create_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_CREATE_FORM_VALID = 'sfs_image.admin.images.create_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_CREATE_SUCCESS = 'sfs_image.admin.images.create_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_CREATE_FORM_INVALID = 'sfs_image.admin.images.create_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_IMAGES_CREATE_VIEW = 'sfs_image.admin.images.create_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_UPDATE_INITIALIZE = 'sfs_image.admin.images.update_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_UPDATE_FORM_VALID = 'sfs_image.admin.images.update_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_UPDATE_SUCCESS = 'sfs_image.admin.images.update_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_UPDATE_FORM_INVALID = 'sfs_image.admin.images.update_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_IMAGES_UPDATE_VIEW = 'sfs_image.admin.images.update_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_DELETE_INITIALIZE = 'sfs_image.admin.images.delete_initialize';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_DELETE_FORM_VALID = 'sfs_image.admin.images.delete_form_valid';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_DELETE_SUCCESS = 'sfs_image.admin.images.delete_success';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseFormEvent")
     */
    public const ADMIN_IMAGES_DELETE_FORM_INVALID = 'sfs_image.admin.images.delete_form_invalid';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_IMAGES_DELETE_VIEW = 'sfs_image.admin.images.delete_view';

    /**
     * @Event("Softspring\Component\CrudlController\Event\GetResponseEntityEvent")
     */
    public const ADMIN_IMAGES_READ_INITIALIZE = 'sfs_image.admin.images.read_initialize';

    /**
     * @Event("Softspring\Component\Events\ViewEvent")
     */
    public const ADMIN_IMAGES_READ_VIEW = 'sfs_image.admin.images.read_view';
}
