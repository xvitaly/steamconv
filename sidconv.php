<?php
/**
*
* @package Steam ID Converters
* @copyright (c) 2005 - 2012 EasyCoding Team
* @license http://www.gnu.org/licenses/gpl.html GPLv3
*
*/
class SteamConv
{
  /**
  * Get the SteamID32 from SteamID64
  *
  * @param string sid SteamID32
  * @return string SteamID64
  */
  public static function get_steamid64($sid)
  {
    return bcadd(self::get_userid($sid), "76561197960265728");
  }
  
  /**
  * Get the userid from SteamID32
  *
  * @param string sid SteamID32
  * @return string UserID
  */
  public static function get_userid($sid)
  {
    $msr = explode(':', $sid);
    return (($msr[2]*2) + $msr[1]);
  }
  
  /**
  * Get the SteamID64 from SteamID32
  *
  * @param string sid SteamID32
  * @return string SteamID64
  */
  public static function get_steamid32($sid)
  {
    if (preg_match("/^STEAM_0:[01]:[0-9]{1,9}$/", $sid))
    {
      return $sid;
    }
    else
    {
      $srx = (substr($sid, -1) % 2 == 0) ? 0 : 1;
      $arx = bcsub($sid, "76561197960265728");
      if (bccomp($arx, "0") != 1) { throw new InvalidArgumentException("Invalid SteamID"); }
      $arx = bcsub($arx, $srx);
      $arx = bcdiv($arx, 2);
      return sprintf("STEAM_0:%s:%s", $srx, $arx);
    }
  }
}
?>