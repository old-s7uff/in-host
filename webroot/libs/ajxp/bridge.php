<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * LICENSE:
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @categories	Games/Entertainment, Systems Administration
 * @package		Bright Game Panel
 * @author		warhawk3407 <warhawk3407@gmail.com> @NOSPAM
 * @copyleft	2013
 * @license		GNU General Public License version 3.0 (GPLv3)
 * @version		(Release 0) DEVELOPER BETA 9
 * @link		http://www.bgpanel.net/
 */



/**
 *	@Class:		AjaXplorer Bridge Class For BrightGamePanel
 *	@Version:	1.0
 *	@Date:		29/08/2013
 */
class AJXP_Bridge {

	//------------------------------------------------------------------------------------------------------------+
	//------------------------------------------------------------------------------------------------------------+

	// VARIABLES

	//------------------------------------------------------------------------------------------------------------+
	//------------------------------------------------------------------------------------------------------------+

	/**
	 * BGPanel Workspaces
	 *
	 * @var Array
	 * @access private
	 */
	private $bgpWorkspaces	= array();

	/**
	 * AJXP-Ready Workspaces
	 *
	 * @var Array
	 * @access private
	 */
	private $ajxpWorkspaces	= array();

	/**
	 * BGPanel User
	 *
	 * @var String
	 * @access private
	 */
	private $bgpUser		= '';

	/**
	 * AJXP Data Directories
	 *
	 * @var String
	 * @access private
	 */
	private $AJXP_DATA_PATH					=	'';
	private $AJXP_DATA_CONFSERIAL_REPOFILE	=	'';
	private $AJXP_DATA_AUTHSERIAL_DIR		=	'';


	//------------------------------------------------------------------------------------------------------------+
	//------------------------------------------------------------------------------------------------------------+

	// FUNCTIONS

	//------------------------------------------------------------------------------------------------------------+
	//------------------------------------------------------------------------------------------------------------+

	// Default Constructor
	function __construct( $boxes, $servers, $user )
	{
		// Var INIT
		$this->AJXP_DATA_PATH 					=	substr( realpath(dirname(__FILE__)), 0, -10 ).'/ajxp/data';
		$this->AJXP_DATA_CONFSERIAL_REPOFILE	=	$this->AJXP_DATA_PATH.'/plugins/conf.serial/repo.ser';
		$this->AJXP_DATA_AUTHSERIAL_DIR			=	$this->AJXP_DATA_PATH.'/plugins/auth.serial';


		// Test write perms
		if (
				(!is_writable($this->AJXP_DATA_PATH)) ||
				(!is_writable($this->AJXP_DATA_CONFSERIAL_REPOFILE)) ||
				(!is_writable($this->AJXP_DATA_AUTHSERIAL_DIR))
			)
		{
			trigger_error("AJXP DATA DIRECTORY IS NOT WRITABLE!", E_USER_ERROR);
			exit( 'AJXP DATA DIRECTORY IS NOT WRITABLE!' );
		}


		// Test params
		if ( empty($user) )
		{
			trigger_error("NO BGP USER GIVEN FOR AjaXplorer Bridge Class!", E_USER_ERROR);
			exit( 'NO BGP USER GIVEN FOR AjaXplorer Bridge Class!' );
		}


		$this->bgpWorkspaces	= array_merge($this->bgpWorkspaces, $boxes);
		$this->bgpWorkspaces	= array_merge($this->bgpWorkspaces, $servers);
		$this->bgpUser			= $user;
	}

	//------------------------------------------------------------------------------------------------------------+
	//------------------------------------------------------------------------------------------------------------+

	/**
	 * Create a 32 chars Pseudo-UID for AJXP
	 *
	 * @param $workspaceID, $workspaceType
	 * @return String
	 * @access private
	 */
	private function createUid( $workspaceID, $workspaceType )
	{
		$uuid = md5( $workspaceType.'-'.$workspaceID );
		return $uuid;
	}

	/**
	 * Update AJXP repo serialized file
	 *
	 * @param void
	 * @return bool
	 * @access public
	 */
	public function updateAJXPWorspaces( )
	{
		foreach ( $this->bgpWorkspaces as $key => $item )
		{
			// Create UUID from item ID
			if ( array_key_exists( 'boxid', $item ) ) {
				$repositoryUuid = $this->createUid( $item['boxid'], 'box' );
				$prefix = 'Box - ';
			}
			else if ( array_key_exists( 'serverid', $item ) ) {
				$repositoryUuid = $this->createUid( $item['serverid'], 'server' );
				$prefix = 'Game Server - ';
			}

			$repository = array(
				"AJXP_PHP_Object" => 'Repository',
				"uuid" => $repositoryUuid,
				"id" => 0,
				"path" => NULL,
				"display" => $prefix.$item['name'],
				"displayStringId" => NULL,
				"accessType" => 'sftp_psl',
				"recycle" => '',
				"create" => TRUE,
				"writeable" => TRUE,
				"enabled" => TRUE,
				"options" => Array
					(
						"CREATION_TIME" => time(),
						"CREATION_USER" => $this->bgpUser,
						"SFTP_HOST" => $item['ip'],
						"SFTP_PORT" => $item['sshport'],
						"PATH" => $item['path'],
						"FIX_PERMISSIONS" => 'detect_remote_user_id',
						"USER" => $item['login'],
						"PASS" => $item['password'],
						"USE_SESSION_CREDENTIALS" => FALSE,
						"RECYCLE_BIN" => 'recycle_bin',
						"CHARSET" => '',
						"PAGINATION_THRESHOLD" => '500',
						"PAGINATION_NUMBER" => '200',
						"USER_DESCRIPTION" => '',
						"AJXP_SLUG" => '',
						"DEFAULT_RIGHTS" => 'rw',
						"META_SOURCES" => Array
							(
								"metastore.serial" => Array
									(
										"METADATA_FILE_LOCATION" => 'infolders',
										"METADATA_FILE" => '.ajxp_meta'
									),
								"meta.filehasher" => Array
									(
									),
								"index.lucene" => Array
									(
										"index_content" => 'false',
										"index_meta_fields" => '',
										"repository_specific_keywords" => ''
									)
							)
					),
				"slug" => $item['name'],
				"isTemplate" => FALSE,
				" Repository owner" => NULL,
				" Repository parentId" => NULL,
				" Repository uniqueUser" => NULL,
				" Repository inferOptionsFromParent" => FALSE,
				" Repository parentTemplateObject" => NULL,
				"streamData" => NULL,
				" * groupPath" => NULL,
				"driverInstance" => NULL
			);

			$this->ajxpWorkspaces[$repositoryUuid] = $repository;
		}

		// Create Repofile for AJXP
		$ser = serialize( $this->ajxpWorkspaces );
		$ser = str_replace( "a:22:{s:15:\"AJXP_PHP_Object\";s:10:\"Repository\";", "O:10:\"Repository\":21:{", $ser ); // AJXP Object fix

		// Put contents
		$handle = fopen( $this->AJXP_DATA_CONFSERIAL_REPOFILE, "w+" );
		fwrite( $handle, $ser );
		fclose( $handle );

		return TRUE;
	}

	/**
	 * Update Current AJXP user
	 * Add correct repositories to the user with rw perms
	 *
	 * @param void
	 * @return bool
	 * @access public
	 */
	public function updateAJXPUser( )
	{
		// Create Workspaces UIDs (useful when updating only the user)
		foreach ( $this->bgpWorkspaces as $key => $item )
		{
			// Create UUID from item ID
			if ( array_key_exists( 'boxid', $item ) ) {
				$repositoryUuid = $this->createUid( $item['boxid'], 'box' );
			}
			else if ( array_key_exists( 'serverid', $item ) ) {
				$repositoryUuid = $this->createUid( $item['serverid'], 'server' );
			}

			$this->ajxpWorkspaces[$repositoryUuid] = '';
		}

		// Check user directory
		if ( !is_dir( $this->AJXP_DATA_AUTHSERIAL_DIR.'/'.$this->bgpUser ) ) {
			// Create a new directory
			mkdir( $this->AJXP_DATA_AUTHSERIAL_DIR.'/'.$this->bgpUser, 0755 );
		}

		// Build Workspaces array
		$acls = array(
			"ajxp_conf" => "rw"
		);

		// Give rights
		foreach ( $this->ajxpWorkspaces as $key => $item ) {
			$acls[$key] = "rw";
		}

		// Create Rolefile
		$role = array(
			"AJXP_PHP_Object" => 'AJXP_Role',
			" * groupPath" => NULL,
			" * roleId" => "AJXP_USR_/".$this->bgpUser,
			" * roleLabel" => NULL,
			" * acls" => $acls,
			" * parameters" => array(),
			" * actions" => array(),
			" * autoApplies" => array()
		);

		$ser = serialize( $role );
		$ser = str_replace( "a:8:{s:15:\"AJXP_PHP_Object\";s:9:\"AJXP_Role\";", "O:9:\"AJXP_Role\":7:{", $ser ); // AJXP Object fix

		// Put contents
		$handle = fopen( $this->AJXP_DATA_AUTHSERIAL_DIR.'/'.$this->bgpUser.'/'.'role.ser', "w+" );
		fwrite( $handle, $ser );
		fclose( $handle );

		return TRUE;
	}

}



?>