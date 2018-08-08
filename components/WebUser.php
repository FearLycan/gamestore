<?php
namespace app\components;
use yii\web\User;
/**
 * App WebUser implementation.
 *
 * @property \app\models\User $identity
 *
 */
class WebUser extends User
{
    /**
     * @var int
     */
    public $lastSeenDelay = 300;
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // refresh `last_seen` stamp
        if (!$this->isGuest && (strtotime($this->identity->last_seen) + $this->lastSeenDelay) < time()) {
            $this->identity->last_seen = date('Y-m-d H:i:s');
            $this->identity->save(false, [
                'last_seen',
            ]);
        }
    }
    /**
     * Check if current user has specified status.
     * @param int|array $status Status ID or array of statuses IDs.
     * @return bool
     */
    public function hasStatus($status)
    {
        if ($this->isGuest) {
            return false;
        } elseif (is_array($status)) {
            return in_array($this->identity->status, $status, true);
        } else {
            return $this->identity->status === $status;
        }
    }
}