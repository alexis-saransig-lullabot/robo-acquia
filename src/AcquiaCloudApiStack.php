<?php

/**
 * @file
 * The Acquia Cloud API Robo task, originally generated by the Robo task
 * generator.
 */

namespace Lullabot\RoboAcquia;

use AcquiaCloudApi\Endpoints\Account;
use AcquiaCloudApi\Endpoints\Code;
use AcquiaCloudApi\Endpoints\Crons;
use AcquiaCloudApi\Endpoints\DatabaseBackups;
use AcquiaCloudApi\Endpoints\Databases;
use AcquiaCloudApi\Endpoints\Domains;
use AcquiaCloudApi\Endpoints\Environments;
use AcquiaCloudApi\Endpoints\Insights;
use AcquiaCloudApi\Endpoints\Organizations;
use AcquiaCloudApi\Endpoints\Permissions;
use AcquiaCloudApi\Endpoints\Roles;
use AcquiaCloudApi\Endpoints\Servers;
use AcquiaCloudApi\Endpoints\Teams;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\BranchesResponse;
use AcquiaCloudApi\Response\BranchResponse;
use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\CronsResponse;
use AcquiaCloudApi\Response\DatabaseNamesResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\InsightResponse;
use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\InvitationResponse;
use AcquiaCloudApi\Response\InvitationsResponse;
use AcquiaCloudApi\Response\MemberResponse;
use AcquiaCloudApi\Response\MembersResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\OrganizationResponse;
use AcquiaCloudApi\Response\OrganizationsResponse;
use AcquiaCloudApi\Response\PermissionResponse;
use AcquiaCloudApi\Response\PermissionsResponse;
use AcquiaCloudApi\Response\RoleResponse;
use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\ServerResponse;
use AcquiaCloudApi\Response\ServersResponse;
use AcquiaCloudApi\Response\TeamResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use Psr\Http\Message\StreamInterface;
use Robo\Result;
use Robo\State\StateAwareInterface;
use Robo\State\StateAwareTrait;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Applications;
use Robo\Task\StackBasedTask;

/**
 * Wrapper for Client Component.
 * Comands are executed in stack and can be stopped on first fail with
 * `stopOnFail` option.
 *
 * ``` php
 * <?php
 * $this->taskAcquiaCloudApi()
 *      ...
 *      ->run();
 *
 * // one line
 * ...
 *
 * ?>
 * ```
 */
class AcquiaCloudApiStack extends StackBasedTask implements StateAwareInterface
{
    use StateAwareTrait;

    protected $delegate;
    protected $connector;
    protected $database;
    protected $application;
    protected $code;
    protected $databaseBackup;
    protected $environment;
    protected $domain;
    protected $server;
    protected $cron;
    protected $insight;
    protected $organization;
    protected $role;
    protected $team;
    protected $permission;

    /**
     * Constructor.
     *
     * @param iterable $config
     *   Config for connecting to the Acquia Cloud API.
     */
    public function __construct(iterable $config = [])
    {
        $this->connector = new Connector($config);
        $this->delegate = new Client($this->connector);
        $this->database = new Databases($this->delegate);
        $this->application = new Applications($this->delegate);
        $this->code = new Code($this->delegate);
        $this->databaseBackup = new DatabaseBackups($this->delegate);
        $this->environment = new Environments($this->delegate);
        $this->domain = new Domains($this->delegate);
        $this->server = new Servers($this->delegate);
        $this->cron = new Crons($this->delegate);
        $this->account = new Account($this->delegate);
        $this->insight = new Insights($this->delegate);
        $this->organization = new Organizations($this->delegate);
        $this->role = new Roles($this->delegate);
        $this->team = new Teams($this->delegate);
        $this->permission = new Permissions($this->delegate);
    }

    protected function getConnector()
    {
        return $this->connector;
    }

    protected function getDelegate()
    {
        return $this->delegate;
    }

    protected function getDatabase()
    {
        return $this->database;
    }

    protected function getApplication()
    {
        return $this->application;
    }

    protected function getCode()
    {
        return $this->code;
    }

    protected function getDatabaseBackup()
    {
        return $this->databaseBackup;
    }

    protected function getEnvironment()
    {
        return $this->environment;
    }

    protected function getDomain()
    {
        return $this->domain;
    }

    protected function getServer()
    {
        return $this->server;
    }

    protected function getCron()
    {
        return $this->cron;
    }

    protected function getAccount()
    {
        return $this->account;
    }

    protected function getInsight()
    {
        return $this->insight;
    }

    protected function getOrganization()
    {
        return $this->organization;
    }

    protected function getRole()
    {
        return $this->role;
    }

    protected function getTeam()
    {
        return $this->team;
    }

    protected function getPermission()
    {
        return $this->permission;
    }

    public function getQuery()
    {
        return $this->delegate->getQuery();
    }

    /**
     * Clear query.
     *
     * @return $this
     */
    public function clearQuery()
    {
        $this->delegate->clearQuery();
        return $this;
    }

    /**
     * Add a query parameter to filter results.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addQuery($name, $value)
    {
        $this->delegate->addQuery($name, $value);
        return $this;
    }

    /**
     * Wait for the Acquia tasks to complete.
     *
     * @param string   $applicationUuid
     *   The Acquia application UUID to check for tasks on.
     * @param string   $name
     *   The name of the task to wait for completion.
     * @param int      $timeout
     *   The timeout in seconds to wait. Defaults to 120 (2 minutes).
     * @param callable $callback
     *   An optional callback to provide feedback during the watch loop.
     *
     * @return $this
     */
    public function waitForTaskCompletion($applicationUuid, $name, $timeout = 120, callable $callback = null)
    {
        $task_watcher = new AcquiaTaskWatcher($this->delegate, $applicationUuid);
        $this->addToCommandStack([$task_watcher, 'watch'], [$name, $timeout, $callback]);
        return $this;
    }

    protected function _deployCode($environmentFromUuid, $environmentToUuid, $commitMessage = null)
    {
        $this->delegate->deployCode($environmentFromUuid, $environmentToUuid, $commitMessage);
    }

    protected function _createRole($organizationUuid, $name, $permissions, $description = null)
    {
        $this->delegate->createRole($organizationUuid, $name, $permissions, $description);
    }

    /**
     * {@inheritdoc}
     */
    protected function processResult($function_result)
    {
        if ($function_result instanceof \ArrayObject) {
            $data['result'] = $function_result;
            return Result::success($this, '', $data);
        }
        if ($function_result instanceof OperationResponse) {
            /* @var \AcquiaCloudApi\Response\OperationResponse $function_result */
            return Result::success($this, $function_result->message);
        }
        if ($function_result instanceof EnvironmentResponse) {
            return Result::success($this, '', $function_result);
        }
        if ($function_result instanceof BackupsResponse) {
            return Result::success($this, '', $function_result);
        }
        if (!$function_result) {
            return Result::error($this, 'Acquia returned an empty or falsey response.');
        }
        return Result::error($this, 'Unable to detect the type of response in processResult().', $function_result);
    }

    /**
     * Show all teams.
     */
    public function getAll()
    {
        $team = $this->getTeam();
        $team->getAll();
        return $this;
    }

    /**
     * Create a new team.
     */
    public function createTeam(string $organizationUuid, string $name)
    {
        $team = $this->getTeam();
        $team->create($organizationUuid, $name);
        return $this;
    }

    /**
     * Rename an existing team.
     */
    public function renameTeam(string $teamUuid, string $name)
    {
        $team = $this->getTeam();
        $team->rename($teamUuid, $name);
        return $this;
    }

    /**
     * Delete a team.
     */
    public function deleteTeam(string $teamUuid)
    {
        $team = $this->getTeam();
        $team->delete($teamUuid);
        return $this;
    }

    /**
     * Add an application to a team.
     */
    public function addApplicationToTeam(string $teamUuid, string $applicationUuid)
    {
        $team = $this->getTeam();
        $team->addApplication($teamUuid, $applicationUuid);
        return $this;
    }

    /**
     * Show all applications associated with a team.
     */
    public function getApplications(string $teamUuid)
    {
        $team = $this->getTeam();
        $team->getApplications($teamUuid);
        return $this;
    }

    /**
     * Invites a user to join a team.
     */
    public function createTeamInvite(string $teamUuid, string $email, array $roles)
    {
        $team = $this->getTeam();
        $team->invite($teamUuid, $email, $roles);
        return $this;
    }

    /**
     * Show all organizations.
     */
    public function organizations()
    {
        $organization = $this->getOrganization();
        $organization->getAll();
        return $this;
    }

    /**
     * Show all members of an organization.
     */
    public function members(string $organizationUuid)
    {
        $organization = $this->getOrganization();
        $organization->getMembers($organizationUuid);
        return $this;
    }

    /**
     * Delete a member from an organization.
     */
    public function deleteMember(string $organizationUuid, string $memberUuid)
    {
        $organization = $this->getOrganization();
        $organization->deleteMember($organizationUuid, $memberUuid);
        return $this;
    }

    /**
     * Show all members invited to an organization.
     */
    public function invitees(string $organizationUuid)
    {
        $organization = $this->getOrganization();
        $organization->getMembers($organizationUuid);
        return $this;
    }

    /**
     * Show all teams in an organization.
     */
    public function organizationTeams(string $organizationUuid)
    {
        $organization = $this->getOrganization();
        $organization->getTeams($organizationUuid);
        return $this;
    }

    /**
     * Show all applications in an organization.
     */
    public function organizationApplications(string $organizationUuid)
    {
        $organization = $this->getOrganization();
        $organization->getApplications($organizationUuid);
        return $this;
    }

    /**
     * Show all roles in an organization.
     */
    public function organizationRoles(string $organizationUuid)
    {
        $role = $this->getRole();
        $role->getAll($organizationUuid);
        return $this;
    }

    /**
     * Invites a user to become admin of an organization.
     */
    public function createOrganizationAdminInvite(string $organizationUuid, string $email)
    {
        $organization = $this->getOrganization();
        $organization->inviteAdmin($organizationUuid, $email);
        return $this;
    }

    /**
     * Create a new role.
     */
    public function createRole(
        string $organizationUuid,
        string $name,
        array $permissions,
        string $description = null
    ) {
        $role = $this->getRole();
        $role->create($organizationUuid, $name, $permissions, $description);
        return $this;
    }

    /**
     * Update the permissions associated with a role.
     */
    public function updateRole(string $roleUuid, array $permissions)
    {
        $role = $this->getRole();
        $role->update($roleUuid, $permissions);
        return $this;
    }

    /**
     * Delete a role.
     */
    public function deleteRole(string $roleUuid)
    {
        $role = $this->getRole();
        $role->delete($roleUuid);
        return $this;
    }

    /**
     * Show all available permissions.
     */
    public function permissions()
    {
        $permission = $this->getPermission();
        $permission->get();
        return $this;
    }

    /**
     * Copies a database from an environment to an environment.
     */
    public function databaseCopy(string $environmentFromUuid, string $dbName, string $environmentToUuid)
    {
        $database = $this->getDatabase();
        $database->copy($environmentFromUuid, $dbName, $environmentToUuid);
        return $this;
    }

    /**
     * Create a new database.
     */
    public function databaseCreate(string $applicationUuid, string $name)
    {
        $database = $this->getDatabase();
        $database->create($applicationUuid, $name);
        return $this;
    }

    /**
     * Delete a database
     */
    public function databaseDelete(string $applicationUuid, string $name)
    {
        $database = $this->getDatabase();
        $database->delete($applicationUuid, $name);
        return $this;
    }

    /**
     * Shows all databases in an application.
     */
    public function databases(string $applicationUuid)
    {
        $database = $this->getDatabase();
        $database->getNames($applicationUuid);
        return $this;
    }

    /**
     * Shows all databases in an environment.
     */
    public function environmentDatabases(string $environmentUuid)
    {
        $database = $this->getDatabase();
        $database->getAll($environmentUuid);
        return $this;
    }

    /**
     * Shows all applications.
     */
    public function applications()
    {
        $applications = $this->getApplication();
        $applications->getAll();
        return $this;
    }

    /**
     * Shows information about an application.
     */
    public function application(string $applicationUuid)
    {
        $applications = $this->getApplication();
        $applications->get($applicationUuid);
        return $this;
    }

    /**
     * Renames an application.
     */
    public function renameApplication(string $applicationUuid, string $name)
    {
        $applications = $this->getApplication();
        $applications->rename($applicationUuid, $name);
        return $this;
    }

    /**
     * Shows all code branches and tags in an application.
     */
    public function code(string $applicationUuid)
    {
        $code = $this->getCode();
        $code->getAll($applicationUuid);
        return $this;
    }

    /**
     * Backup a database.
     */
    public function createDatabaseBackup(string $environmentUuid, string $dbName)
    {
        $databaseBackup = $this->getDatabaseBackup();
        $databaseBackup->create($environmentUuid, $dbName);
        return $this;
    }

    /**
     * Shows all database backups in an environment.
     */
    public function databaseBackups(string $environmentUuid, string $dbName)
    {
        $databaseBackup = $this->getDatabaseBackup();
        $databaseBackup->getAll($environmentUuid, $dbName);
        return $this;
    }

    /**
     * Gets information about a database backup.
     */
    public function databaseBackup(string $environmentUuid, string $dbName, int $backupId)
    {
        $databaseBackup = $this->getDatabaseBackup();
        $databaseBackup->get($environmentUuid, $dbName, $backupId);
        return $this;
    }

    /**
     * Restores a database backup to a database in an environment.
     */
    public function restoreDatabaseBackup(string $environmentUuid, string $dbName, int $backupId)
    {
        $databaseBackup = $this->getDatabaseBackup();
        $databaseBackup->get($environmentUuid, $dbName, $backupId);
        return $this;
    }

    /**
     * Copies files from an environment to another environment.
     */
    public function copyFiles(string $environmentUuidFrom, string $environmentUuidTo)
    {
        $environment = $this->getEnvironment();
        $environment->copyFiles($environmentUuidFrom, $environmentUuidTo);
        return $this;
    }

    /**
     * Deploys a code branch/tag to an environment.
     */
    public function switchCode(string $environmentUuid, string $branch)
    {
        $code = $this->getCode();
        $code->switch($environmentUuid, $branch);
        return $this;
    }

    /**
     * Deploys code from one environment to another environment.
     */
    public function deployCode(
        string $environmentFromUuid,
        string $environmentToUuid,
        string $commitMessage = null
    ) {
        $code = $this->getCode();
        $code->deploy($environmentFromUuid, $environmentToUuid, $commitMessage);
        return $this;
    }

    /**
     * Shows all domains on an environment.
     */
    public function domains(string $environmentUuid)
    {
        $domain = $this->getDomain();
        $domain->getAll($environmentUuid);
        return $this;
    }

    /**
     * Adds a domain to an environment.
     */
    public function createDomain(string $environmentUuid, string $hostname)
    {
        $domain = $this->getDomain();
        $domain->create($environmentUuid, $hostname);
        return $this;
    }

    /**
     * Deletes a domain from an environment.
     */
    public function deleteDomain(string $environmentUuid, string $envDomain)
    {
        $domain = $this->getDomain();
        $domain->delete($environmentUuid, $envDomain);
        return $this;
    }

  /**
   * Purges cache for selected domains in an environment.
   */
  public function purgeVarnishCache(string $environmentUuid, array $domains)
  {
        $domain = $this->getDomain();
        $domain->purge($environmentUuid, $domains);
        return $this;
  }

    /**
     * Shows all environments in an application.
     */
    public function environments(string $applicationUuid)
    {
        $environment = $this->getEnvironment();
        $environment->getAll($applicationUuid);
        return $this;
    }

    /**
     * Gets information about an environment.
     */
    public function environment(string $environmentUuid)
    {
        $environment = $this->getEnvironment();
        $environment->get($environmentUuid);
        return $this;
    }

    /**
     * Renames an environment.
     */
    public function renameEnvironment(string $environmentUuid, string $label)
    {
        $environment = $this->getEnvironment();
        $environment->rename($environmentUuid, $label);
        return $this;
    }

    /**
     * Show all servers associated with an environment.
     */
    public function servers(string $environmentUuid)
    {
        $server = $this->getServer();
        $server->getAll($environmentUuid);
        return $this;
    }

    /**
     * Enable livedev mode for an environment.
     */
    public function enableLiveDev(string $environmentUuid)
    {
        $environment = $this->getEnvironment();
        $environment->enableLiveDev($environmentUuid);
        return $this;
    }

    /**
     * Disable livedev mode for an environment.
     */
    public function disableLiveDev(string $environmentUuid)
    {
        $environment = $this->getEnvironment();
        $environment->disableLiveDev($environmentUuid);
        return $this;
    }

    /**
     * Enable production mode for an environment.
     */
    public function enableProductionMode(string $environmentUuid)
    {
        $environment = $this->getEnvironment();
        $environment->enableProductionMode($environmentUuid);
        return $this;
    }

    /**
     * Disable production mode for an environment.
     */
    public function disableProductionMode(string $environmentUuid)
    {
        $environment = $this->getEnvironment();
        $environment->disableProductionMode($environmentUuid);
        return $this;
    }

    /**
     * Show all cron tasks for an environment.
     */
    public function crons(string $environmentUuid)
    {
        $cron = $this->getCron();
        $cron->getAll($environmentUuid);
        return $this;
    }

    /**
     * Get information about a cron task.
     */
    public function cron(string $environmentUuid, int $cronId)
    {
        $cron = $this->getCron();
        $cron->get($environmentUuid, $cronId);
        return $this;
    }

    /**
     * Add a cron task.
     */
    public function createCron(
        string $environmentUuid,
        string $command,
        string $frequency,
        string $label,
        string $serverId = null
    ) {
        $cron = $this->getCron();
        $cron->create($environmentUuid, $command, $frequency, $label, $serverId);
        return $this;
    }

    /**
     * Delete a cron task.
     */
    public function deleteCron(string $environmentUuid, int $cronId)
    {
        $cron = $this->getCron();
        $cron->delete($environmentUuid, $cronId);
        return $this;
    }

    /**
     * Disable a cron task.
     */
    public function disableCron(string $environmentUuid, int $cronId)
    {
        $cron = $this->getCron();
        $cron->disable($environmentUuid, $cronId);
        return $this;
    }

    /**
     * Enable a cron task.
     */
    public function enableCron(string $environmentUuid, int $cronId)
    {
        $cron = $this->getCron();
        $cron->enable($environmentUuid, $cronId);
        return $this;
    }

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     */
    public function drushAliases()
    {
        $account = $this->getAccount();
        $account->getDrushAliases();
        return $this;
    }

    /**
     * Returns Insight data for all sites associated with the application by its
     * UUID.
     */
    public function applicationInsights(string $applicationUuid)
    {
        $insight = $this->getInsight();
        $insight->getAll($applicationUuid);
        return $this;
    }

    /**
     * Returns Insight data for all sites associated with the environment by its
     * UUID.
     */
    public function environmentInsights(string $environmentUuid)
    {
        $insight = $this->getInsight();
        $insight->getEnvironment($environmentUuid);
        return $this;
    }
}
