<?php
/**
 * Adds IP from comment that marked as spam to standard WordPress blacklist. Comments already marked as spam are not added to the list.
 *
 * @link              https://gitlab.com/proninyaroslav/spam-to-blacklist
 * @since             1.0
 * @package           SpamToBlacklist
 *
 * @wordpress-plugin
 * Plugin Name:       Spam to blacklist
 * Plugin URI:        https://gitlab.com/proninyaroslav/spam-to-blacklist
 * Description:       Adds IP from comment that marked as spam to standard WordPress blacklist. Comments already marked as spam are not added to the list.
 * Version:           1.0
 * Author:            Yaroslav Pronin
 * Author URI:        https://proninyaroslav.ru
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
 * Copyright (C) 2018 Yaroslav Pronin <proninyaroslav@mail.ru>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

add_action('spam_comment', 'SpamToBlacklist_ban', 10, 2);
add_action('unspam_comment', 'SpamToBlacklist_unban', 10, 2);

function SpamToBlacklist_ban($comment_id, $comment)
{
	$blacklist = get_option('blacklist_keys', '');
	$blacklist .= "\n" . $comment->comment_author_IP;
	update_option('blacklist_keys', $blacklist);
}

function SpamToBlacklist_unban($comment_id, $comment)
{
	$blacklist = get_option('blacklist_keys', '');
	$blacklist = str_replace($comment->comment_author_IP, '', $blacklist);
	update_option('blacklist_keys', $blacklist);
}
