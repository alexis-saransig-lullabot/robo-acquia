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
 *
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
     *
     * @return TeamsResponse<TeamResponse>
     */
    public function getAll(): TeamsResponse
    {
        $team = $this->getTeam();
        return $team->getAll();
    }

    /**
     * Create a new team.
     */
    public function createTeam(string $organizationUuid, string $name): OperationResponse
    {
        $team = $this->getTeam();
        return $team->create($organizationUuid, $name);
    }

    /**
     * Rename an existing team.
     */
    public function renameTeam(string $teamUuid, string $name): OperationResponse
    {
        $team = $this->getTeam();
        return $team->rename($teamUuid, $name);
    }

    /**
     * Delete a team.
     */
    public function deleteTeam(string $teamUuid): OperationResponse
    {
        $team = $this->getTeam();
        return $team->delete($teamUuid);
    }

    /**
     * Add an application to a team.
     */
    public function addApplicationToTeam(string $teamUuid, string $applicationUuid): OperationResponse
    {
        $team = $this->getTeam();
        return $team->addApplication($teamUuid, $applicationUuid);
    }

    /**
     * Show all applications associated with a team.
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function getApplications(string $teamUuid): ApplicationsResponse
    {
        $team = $this->getTeam();
        return $team->getApplications($teamUuid);
    }

    /**
     * Invites a user to join a team.
     *
     * @param string[] $roles
     */
    public function createTeamInvite(string $teamUuid, string $email, array $roles): OperationResponse
    {
        $team = $this->getTeam();
        return $team->invite($teamUuid, $email, $roles);
    }

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse<OrganizationResponse>
     */
    public function organizations(): OrganizationsResponse
    {
        $organization = $this->getOrganization();
        return $organization->getAll();
    }

    /**
     * Show all members of an organization.
     *
     * @return MembersResponse<MemberResponse>
     */
    public function members(string $organizationUuid): MembersResponse
    {
        $organization = $this->getOrganization();
        return $organization->getMembers($organizationUuid);
    }

    /**
     * Delete a member from an organization.
     */
    public function deleteMember(string $organizationUuid, string $memberUuid): OperationResponse
    {
        $organization = $this->getOrganization();
        return $organization->deleteMember($organizationUuid, $memberUuid);
    }

    /**
     * Show all members invited to an organization.
     *
     * @return InvitationsResponse<InvitationResponse>
     */
    public function invitees(string $organizationUuid): InvitationsResponse
    {
        $organization = $this->getOrganization();
        return $organization->getMembers($organizationUuid);
    }

    /**
     * Show all teams in an organization.
     *
     * @return TeamsResponse<TeamResponse>
     */
    public function organizationTeams(string $organizationUuid): TeamsResponse
    {
        $organization = $this->getOrganization();
        return $organization->getTeams($organizationUuid);
    }

    /**
     * Show all applications in an organization.
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function organizationApplications(string $organizationUuid): ApplicationsResponse
    {
        $organization = $this->getOrganization();
        return $organization->getApplications($organizationUuid);
    }

    /**
     * Show all roles in an organization.
     *
     * @return RolesResponse<RoleResponse>
     */
    public function organizationRoles(string $organizationUuid): RolesResponse
    {
        $role = $this->getRole();
        return $role->getAll($organizationUuid);
    }

    /**
     * Invites a user to become admin of an organization.
     */
    public function createOrganizationAdminInvite(string $organizationUuid, string $email): OperationResponse
    {
        $organization = $this->getOrganization();
        return $organization->inviteAdmin($organizationUuid, $email);
    }

    /**
     * Create a new role.
     *
     * @param array<string> $permissions
     * @param string|null $description
     */
    public function createRole(
        string $organizationUuid,
        string $name,
        array $permissions,
        string $description = null
    ): OperationResponse {
        $role = $this->getRole();
        return $role->create($organizationUuid, $name, $permissions, $description);
    }

    /**
     * Update the permissions associated with a role.
     *
     * @param array<string> $permissions
     */
    public function updateRole(string $roleUuid, array $permissions): OperationResponse
    {
        $role = $this->getRole();
        return $role->update($roleUuid, $permissions);
    }

    /**
     * Delete a role.
     */
    public function deleteRole(string $roleUuid): OperationResponse
    {
        $role = $this->getRole();
        return $role->delete($roleUuid);
    }

    /**
     * Show all available permissions.
     *
     * @return PermissionsResponse<PermissionResponse>
     */
    public function permissions(): PermissionsResponse
    {
        $permission = $this->getPermission();
        return $permission->get();
    }

    /**
     * Copies a database from an environment to an environment.
     *
     * @param string $environmentFromUuid
     * @param string $dbName
     * @param string $environmentToUuid
     * @return OperationResponse
     */
    public function databaseCopy(string $environmentFromUuid, string $dbName, string $environmentToUuid): OperationResponse
    {
        $database = $this->getDatabase();
        return $database->copy($environmentFromUuid, $dbName, $environmentToUuid);
    }

    /**
     * Create a new database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseCreate(string $applicationUuid, string $name): OperationResponse
    {
        $database = $this->getDatabase();
        return $database->create($applicationUuid, $name);
    }

    /**
     * Delete a database
     */
    public function databaseDelete(string $applicationUuid, string $name): OperationResponse
    {
        $database = $this->getDatabase();
        return $database->delete($applicationUuid, $name);
    }

    /**
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     * @return DatabaseNamesResponse
     */
    public function databases(string $applicationUuid): DatabaseNamesResponse
    {
        $database = $this->getDatabase();
        return $database->getNames($applicationUuid);
    }

    /**
     * Shows all databases in an environment.
     */
    public function environmentDatabases(string $environmentUuid): DatabasesResponse
    {
        $database = $this->getDatabase();
        return $database->getAll($environmentUuid);
    }

    /**
     * Shows all applications.
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function applications(): ApplicationsResponse
    {
        $applications = $this->getApplication();
        return $applications->getAll();
    }

    /**
     * Shows information about an application.
     */
    public function application(string $applicationUuid): ApplicationResponse
    {
        $applications = $this->getApplication();
        return $applications->get($applicationUuid);
    }

    /**
     * Renames an application.
     */
    public function renameApplication(string $applicationUuid, string $name): OperationResponse
    {
        $applications = $this->getApplication();
        return $applications->rename($applicationUuid, $name);
    }

    /**
     * Shows all code branches and tags in an application.
     *
     * @return BranchesResponse<BranchResponse>
     */
    public function code(string $applicationUuid): BranchesResponse
    {
        $code = $this->getCode();
        return $code->getAll($applicationUuid);
    }

    /**
     * Backup a database.
     */
    public function createDatabaseBackup(string $environmentUuid, string $dbName): OperationResponse
    {
        $databaseBackup = $this->getDatabaseBackup();
        return $databaseBackup->create($environmentUuid, $dbName);
    }

    /**
     * Shows all database backups in an environment.
     *
     * @return BackupsResponse<BackupResponse>
     */
    public function databaseBackups(string $environmentUuid, string $dbName): BackupsResponse
    {
        $databaseBackup = $this->getDatabaseBackup();
        return $databaseBackup->getAll($environmentUuid, $dbName);
    }

    /**
     * Gets information about a database backup.
     */
    public function databaseBackup(string $environmentUuid, string $dbName, int $backupId): BackupResponse
    {
        $databaseBackup = $this->getDatabaseBackup();
        return $databaseBackup->get($environmentUuid, $dbName, $backupId);
    }

    /**
     * Restores a database backup to a database in an environment.
     */
    public function restoreDatabaseBackup(string $environmentUuid, string $dbName, int $backupId): OperationResponse
    {
        $databaseBackup = $this->getDatabaseBackup();
        return $databaseBackup->get($environmentUuid, $dbName, $backupId);
    }

    /**
     * Copies files from an environment to another environment.
     */
    public function copyFiles(string $environmentUuidFrom, string $environmentUuidTo): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->copyFiles($environmentUuidFrom, $environmentUuidTo);
    }

    /**
     * Deploys a code branch/tag to an environment.
     */
    public function switchCode(string $environmentUuid, string $branch): OperationResponse
    {
        $code = $this->getCode();
        return $code->switch($environmentUuid, $branch);
    }

    /**
     * Deploys code from one environment to another environment.
     *
     * @param string|null $commitMessage
     */
    public function deployCode(
        string $environmentFromUuid,
        string $environmentToUuid,
        string $commitMessage = null
    ): OperationResponse {
        $code = $this->getCode();
        return $code->deploy($environmentFromUuid, $environmentToUuid, $commitMessage);
    }

    /**
     * Shows all domains on an environment.
     *
     * @return DomainsResponse<DomainResponse>
     */
    public function domains(string $environmentUuid): DomainsResponse
    {
        $domain = $this->getDomain();
        return $domain->getAll($environmentUuid);
    }

    /**
     * Adds a domain to an environment.
     */
    public function createDomain(string $environmentUuid, string $hostname): OperationResponse
    {
        $domain = $this->getDomain();
        return $domain->create($environmentUuid, $hostname);
    }

    /**
     * Deletes a domain from an environment.
     */
    public function deleteDomain(string $environmentUuid, string $envDomain): OperationResponse
    {
        $domain = $this->getDomain();
        return $domain->delete($environmentUuid, $envDomain);
    }

    /**
     * Shows all environments in an application.
     *
     * @return EnvironmentsResponse<EnvironmentResponse>
     */
    public function environments(string $applicationUuid): EnvironmentsResponse
    {
        $environment = $this->getEnvironment();
        return $environment->getAll($applicationUuid);
    }

    /**
     * Gets information about an environment.
     */
    public function environment(string $environmentUuid): EnvironmentResponse
    {
        $environment = $this->getEnvironment();
        return $environment->get($environmentUuid);
    }

    /**
     * Renames an environment.
     */
    public function renameEnvironment(string $environmentUuid, string $label): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->rename($environmentUuid, $label);
    }

    /**
     * Show all servers associated with an environment.
     *
     * @return ServersResponse<ServerResponse>
     */
    public function servers(string $environmentUuid): ServersResponse
    {
        $server = $this->getServer();
        return $server->getAll($environmentUuid);
    }

    /**
     * Enable livedev mode for an environment.
     */
    public function enableLiveDev(string $environmentUuid): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->enableLiveDev($environmentUuid);
    }

    /**
     * Disable livedev mode for an environment.
     */
    public function disableLiveDev(string $environmentUuid): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->disableLiveDev($environmentUuid);
    }

    /**
     * Enable production mode for an environment.
     */
    public function enableProductionMode(string $environmentUuid): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->enableProductionMode($environmentUuid);
    }

    /**
     * Disable production mode for an environment.
     */
    public function disableProductionMode(string $environmentUuid): OperationResponse
    {
        $environment = $this->getEnvironment();
        return $environment->disableProductionMode($environmentUuid);
    }

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse<CronResponse>
     */
    public function crons(string $environmentUuid): CronsResponse
    {
        $cron = $this->getCron();
        return $cron->getAll($environmentUuid);
    }

    /**
     * Get information about a cron task.
     *
     * @param string $environmentUuid The environment ID
     */
    public function cron(string $environmentUuid, int $cronId): CronResponse
    {
        $cron = $this->getCron();
        return $cron->get($environmentUuid, $cronId);
    }

    /**
     * Add a cron task.
     *
     * @param string|null $serverId
     */
    public function createCron(
        string $environmentUuid,
        string $command,
        string $frequency,
        string $label,
        string $serverId = null
    ): OperationResponse {
        $cron = $this->getCron();
        return $cron->create($environmentUuid, $command, $frequency, $label, $serverId);
    }

    /**
     * Delete a cron task.
     */
    public function deleteCron(string $environmentUuid, int $cronId): OperationResponse
    {
        $cron = $this->getCron();
        return $cron->delete($environmentUuid, $cronId);
    }

    /**
     * Disable a cron task.
     */
    public function disableCron(string $environmentUuid, int $cronId): OperationResponse
    {
        $cron = $this->getCron();
        return $cron->disable($environmentUuid, $cronId);
    }

    /**
     * Enable a cron task.
     */
    public function enableCron(string $environmentUuid, int $cronId): OperationResponse
    {
        $cron = $this->getCron();
        return $cron->enable($environmentUuid, $cronId);
    }

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     */
    public function drushAliases(): StreamInterface
    {
        $account = $this->getAccount();
        return $account->getDrushAliases();
    }

    /**
     * Returns Insight data for all sites associated with the application by its
     * UUID.
     *
     * @return InsightsResponse<InsightResponse>
     */
    public function applicationInsights(string $applicationUuid): InsightsResponse
    {
        $insight = $this->getInsight();
        return $insight->getAll($applicationUuid);
    }

    /**
     * Returns Insight data for all sites associated with the environment by its
     * UUID.
     *
     * @return InsightsResponse<InsightResponse>
     */
    public function environmentInsights(string $environmentUuid): InsightsResponse
    {
        $insight = $this->getInsight();
        return $insight->getEnvironment($environmentUuid);
    }
}
