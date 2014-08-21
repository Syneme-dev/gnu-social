<?php
/**
 * StatusNet, the distributed open-source microblogging tool
 *
 * Check to see whether a user a member of a group
 *
 * PHP version 5
 *
 * LICENCE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  API
 * @package   StatusNet
 * @author    Craig Andrews <candrews@integralblue.com>
 * @author    Evan Prodromou <evan@status.net>
 * @author    Jeffery To <jeffery.to@gmail.com>
 * @author    Zach Copley <zach@status.net>
 * @copyright 2009 StatusNet, Inc.
 * @copyright 2009 Free Software Foundation, Inc http://www.fsf.org
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @link      http://status.net/
 */

if (!defined('STATUSNET')) {
    exit(1);
}

/**
 * Returns whether a user is a member of a specified group.
 *
 * @category API
 * @package  StatusNet
 * @author   Craig Andrews <candrews@integralblue.com>
 * @author   Evan Prodromou <evan@status.net>
 * @author   Jeffery To <jeffery.to@gmail.com>
 * @author   Zach Copley <zach@status.net>
 * @license  http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @link     http://status.net/
 */
class ApiAllPersonalTagAction extends ApiPrivateAuthAction
{
    var $group   = null;

    /**
     * Take arguments for running
     *
     * @param array $args $_REQUEST args
     *
     * @return boolean success flag
     */

    protected function prepare(array $args=array())
    {
        parent::prepare($args);
       // $this->target = $this->getTargetProfile(null);
       // $this->group  = $this->getTargetGroup(null);
        $this->tags = $this->getTags();
        return true;
    }

    /**
     * Handle the request
     *
     * Save the new message
     *
     * @return void
     */
    protected function handle()
    {
        parent::handle();
        switch($this->format) {
        case 'xml':
            break;
        case 'json':
            $this->showJsonObjects(  $this->tags);
            //$this->showJsonObjects(array('is_member' => $this->tags ));
            break;
        default:
            // TRANS: Client error displayed when coming across a non-supported API method.
            $this->clientError(_('API method not found.'));
        }
    }

    /**
     * Return true if read only.
     *
     * MAY override
     *
     * @param array $args other arguments
     *
     * @return boolean is read only action?
     */
    function isReadOnly($args)
    {
        return true;
    }
     function getTags()
        {
            $weightexpr = common_sql_weight('notice_tag.created', common_config('tag', 'dropoff'));
            // @fixme should we use the cutoff too? Doesn't help with indexing per-user.

            $qry = 'SELECT notice_tag.tag,notice.profile_id, '.
              $weightexpr . ' as weight ' .
              'FROM notice_tag JOIN notice ' .
              'ON notice_tag.notice_id = notice.id ' .
              'GROUP BY notice_tag.tag ' .
              'ORDER BY weight DESC ';

         //   $limit = TAGS_PER_SECTION;
            $offset = 0;

           // if (common_config('db','type') == 'pgsql') {
           //     $qry .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
           // } else {
           //     $qry .= ' LIMIT ' . $offset . ', ' . $limit;
           // }
             $tagsJson = array();
            $tags = Memcached_DataObject::cachedQuery('Notice_tag',
                                                     sprintf($qry),
                                                     3600);
                                                   //   while ($tags->fetch()) {
                                                     //            $tagsJson[] = clone($tags);
                                                       //      }
                                                             return $tags;
        }
}
