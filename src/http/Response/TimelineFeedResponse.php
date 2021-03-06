<?php

namespace InstagramAPI;

class TimelineFeedResponse extends Response
{
    protected $num_results;
    protected $is_direct_v2_enabled;
    protected $auto_load_more_enabled;
    protected $more_available;
    protected $next_max_id;
    protected $_messages;
    protected $feed_items;
    protected $megaphone;

    public function __construct($response)
    {
        if (self::STATUS_OK == $response['status']) {
            $this->num_results = $response['num_results'];
            $this->is_direct_v2_enabled = $response['is_direct_v2_enabled'];
            $this->auto_load_more_enabled = $response['auto_load_more_enabled'];
            $this->more_available = $response['more_available'];
            $this->next_max_id = $response['next_max_id'];
            $messages = [];
			if ( (isset($response['_messages'])) && (!empty($response['_messages'])) ) {
				foreach($response['_messages'] as $message) {
					$messages[] = new _Message($message);
				}
			}
            $this->_messages = $messages;
            $items = [];
			if ( (isset($response['feed_items'])) && (!empty($response['feed_items'])) ) {
				foreach($response['feed_items'] as $item) {
					if ( (isset($item['media_or_ad'])) ) {
						$items[] = new Item($item['media_or_ad']);
					}
				}
			}
            $this->feed_items = $items;
            $this->megaphone = (isset($response['megaphone'])) ? new FeedAysf($response['megaphone']['feed_aysf']) : NULL;
        } else {
            $this->setMessage($response['message']);
        }
        $this->setStatus($response['status']);
    }

    public function getNumResults()
    {
        return $this->num_results;
    }

    public function isDirectV2Enabled()
    {
        return $this->is_direct_v2_enabled;
    }

    public function autoLoadMoreEnabled()
    {
        return $this->auto_load_more_enabled;
    }

    public function moreAvailable()
    {
        return $this->more_available;
    }

    public function getNextMaxId()
    {
        return $this->next_max_id;
    }

    public function getExternalId()
    {
        return $this->external_id;
    }

    public function getMessages()
    {
        return $this->_messages;
    }

    public function getFeedItems()
    {
        return $this->feed_items;
    }

    public function getMegaphone()
    {
        return $this->megaphone;
    }
}
