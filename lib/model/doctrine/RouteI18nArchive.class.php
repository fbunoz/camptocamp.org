<?php
/*
 * $Id: RouteI18nArchive.class.php 1019 2007-07-23 18:36:35Z alex $
 */
class RouteI18nArchive extends BaseRouteI18nArchive
{
    public static function find($id)
    {
        return sfDoctrine::getTable('RouteI18nArchive')->find($id);
    }
}
