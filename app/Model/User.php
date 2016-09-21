<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Story $Story
 * @property StoryComment $StoryComment
 * @property Award $Award
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter your first name',
				'allowEmpty' => false,
			),
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter your last name',
				'allowEmpty' => false,
			),
		),
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please select a screen name',
				'allowEmpty' => false,
			),
             'unique' => array(
                'rule'    => 'isUnique',
                'message' => 'This screen name is already in use'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Screen name can only be letters, numbers and underscores'
            ),
            'between' => array(
                'rule' => array('between', 3, 255),
                'message' => 'Screen names must be between 6 and 255 characters'
            )
		),
        'email' => array(
            'required' => array(
                'rule' => array('email', true),   
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => 'isUnique',
                'message' => 'This email is already in use',
            ),
            'between' => array(
                'rule' => array('between', 6, 60),
                'message' => 'Email addresses must be between 6 and 255 characters'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'), 
                'message' => 'Password must be a mimimum of 6 characters'
            )
        ),
         
        'password_confirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password'
            ),
             'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Both passwords must match.'
            )
        ),
        'age' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'location' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
		),
        'password_update' => array(
            'min_length' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'password_confirm_update' => array(
             'equaltofield' => array(
                'rule' => array('equaltofield','password_update'),
                'message' => 'Both passwords must match.',
                'required' => false,
            )
        )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StoryComment' => array(
			'className' => 'StoryComment',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'UserAward' => array(
            'className' => 'UserAward',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Award' => array(
			'className' => 'Award',
			'joinTable' => 'awards_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'award_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

       /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check) {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['username']
                )
            )
        );
 
        if(!empty($username)){
            if($this->data[$this->alias]['id'] == $username['User']['id']){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
 
    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
 
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );
 
        if(!empty($email)){
            if($this->data[$this->alias]['id'] == $email['User']['id']){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
     
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
     
    public function equaltofield($check,$otherfield)
    {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }
 
    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
     public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
         
        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
     
        // fallback to our parent
        return parent::beforeSave($options);
    }

    public function getRandomPartner($id) {
        $game = ClassRegistry::init('Game');
        $games = $game->getGamesForUser($id);        
        $existing_partners = '';
        foreach ($games as $g) {
            if ($g['Game']['user_1_id'] == $id) {
                $existing_partners .= $g['Game']['user_2_id'].',';
            } else {
                $existing_partners .= $g['Game']['user_1_id'].',';
            }
        }
        $existing_partners = substr($existing_partners, 0, -1);

        $partners = "";
        if (!empty($existing_partners)) {
            $partners = " AND (id not in ($existing_partners))";
        }

        $user = $this->query("SELECT * FROM users User where User.id != $id $partners ORDER BY rand() LIMIT 1");
        
        return (count($user) > 0) ? $user : NULL;
    }

    public function getFriendPartner($id, $friend_id) {
        $game = ClassRegistry::init('Game');
 
        $existing_game = $game->find('count', array('conditions' => '((user_1_id = '.$id.' and user_2_id = '.$friend_id.') OR (user_2_id = '.$id.' and user_1_id = '.$friend_id.')) AND (game_status != \'deleted\' AND game_status != \'completed\')'));
        if ($existing_game > 0) {
            return NULL;
        }

        $user = $this->query("SELECT * FROM users User where User.id = $friend_id");
        
        return (count($user) > 0) ? $user : NULL;
    }

    public function verify($token) {
        $user = $this->find('first', array('conditions' => 'User.token = \''.$token.'\''));

        if (count($user) > 0) {
            $this->query('update users set token = \'\', status = 1 where id = '.$user['User']['id']);
            return $user;
        }

        return false;
    }

    public function createRecoverToken($data) {
        $user = $this->find('first', array('conditions' => 'User.email = \''.$data.'\' OR User.username = \''.$data.'\''));

        if (count($user) > 0) {
            $token = md5(uniqid(mt_rand(), true));
            $this->query('update users set password_token = \''.$token.'\' where id = '.$user['User']['id']);
            $user = $this->find('first', array('conditions' => 'User.id = '.$user['User']['id']));
            return $user;
        }

        return false;
    }

    public function canSendToUser($email) {
        $this->recursive = -1;
        $user = $this->find('first', array('conditions' => 'User.email = \''.$email.'\''));
        if ($user['User']['receive_emails'] == 1) {
            return true;
        }
        return false;
    }

    public function checkAwards($id) {
        //$this->User->recursive = 2;
        //$user = $this->User->read(null, $id);
        //$this->Session->write('Auth', $user);
        
        App::import('model', 'Game');
        $Game = new Game();
        App::import('model', 'UserAward');
        $UserAward = new UserAward();
        App::import('model', 'Genre');
        $Genre = new Genre();

        $game_count = $Game->getFinishedGameCount($id);

        $UserAward->recursive = -1;
        $awarded = $UserAward->find('all', array('fields' => 'award_id', 'conditions' => 'UserAward.user_id = '.$id));
        $awarded_array = array();
        foreach ($awarded as $a) {
            $awarded_array[] = $a['UserAward']['award_id'];
        }

        //First story game completed.
        if (!in_array(1, $awarded_array)) {
            if ($game_count > 0) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 1;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //genres - compare for 2-14
        for($i = 2;$i <= 14;$i++) {
            if (!in_array($i, $awarded_array) && $game_count > 0) {
                if (!isset($genre_array) || count($genre_array) == 0) {
                    $genre_array = $Genre->getGenreArray();
                }
                if (!isset($genre_counts)) {
                    $genre_counts = $this->query("select genre_id, count(genre_id) as genre_count from games Game, stories Story where Game.id = Story.game_id and (Game.user_1_id = {$id} or Game.user_2_id = {$id}) and (user_1_status = 'finished' and user_2_status = 'finished' and game_status = 'completed') group by genre_id");
                }
                if (!isset($genre_counts_array)) {
                    $genre_counts_array = array();
                    foreach ($genre_counts as $count) {
                        if ($count[0]['genre_count'] > 0) {
                            $genre_counts_array[$count['Story']['genre_id']] = $count[0]['genre_count'];
                        }
                    }
                }

                if (in_array($i - 1, array_keys($genre_counts_array))) {
                    $data = array();
                    $data['UserAward']['user_id'] = $id;
                    $data['UserAward']['award_id'] = $i;
                    $UserAward->create();
                    $UserAward->save($data);
                    $UserAward->clear();
                }
            }
        }

        //Five games with one partner.
        if (!in_array(15, $awarded_array) && $game_count > 4) {
            $award = false;
            $games = $this->query("select user_2_id, count(user_2_id) as partner_count from games Game where user_1_id = ".$id." group by user_2_id having count(user_2_id) >= 5");
            if (count($games) > 0) {
                $award = true;
            } else {
                $games = $this->query("select user_1_id, count(user_1_id) as partner_count from games Game where user_2_id = ".$id." group by user_1_id having count(user_1_id) >= 5");
                if (count($games) > 0) {
                    $award = true;
                }
            }
            
            if ($award === true) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 15;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //Five games with five separate partners.
        if (!in_array(16, $awarded_array) && $game_count > 4) {
            $award = false;
            $games = $this->query("select distinct user_2_id from games Game where user_1_id = ".$id." limit 5");
            if (count($games) === 5) {
                $award = true;
            } else {
                $games = $this->query("select distinct user_1_id from games Game where user_2_id = ".$id." limit 5");
                if (count($games) === 5) {
                    $award = true;
                }
            }
            
            if ($award === true) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 16;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //At least five stories in one genre.
        if (!in_array(18, $awarded_array) && $game_count > 4) {
            $insert = false;
            if (isset($genre_counts_array)) {
                foreach($genre_counts_array as $val) {
                    if ($val > 5) {
                        $insert = true;
                        break;
                    }
                }
            } else {
                if (!isset($genre_counts)) {
                    $genre_counts = $this->query("select genre_id, count(genre_id) as genre_count from games Game, stories Story where Game.id = Story.game_id and (Game.user_1_id = {$id} or Game.user_2_id = {$id}) and (user_1_status = 'finished' and user_2_status = 'finished' and game_status = 'completed') group by genre_id");
                }
                foreach ($genre_counts as $count) {
                    if ($count[0]['genre_count'] > 0) {
                        $insert = true;
                        break;
                    }
                }
            }

            if ($insert === true) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 18;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //At least one story in every genre.
        if (!in_array(19, $awarded_array) && $game_count > 0) {
            if (!isset($genre_array) || count($genre_array) == 0) {
                $genre_array = $Genre->getGenreArray();
            }
            if (!isset($genre_counts)) {
                $genre_counts = $this->query("select genre_id, count(genre_id) as genre_count from games Game, stories Story where Game.id = Story.game_id and (Game.user_1_id = {$id} or Game.user_2_id = {$id}) and (user_1_status = 'finished' and user_2_status = 'finished' and game_status = 'completed') group by genre_id");
            }
            if (!isset($genre_counts_array)) {
                $genre_counts_array = array();
                foreach ($genre_counts as $count) {
                    if ($count[0]['genre_count'] > 0) {
                        $genre_counts_array[$count['Story']['genre_id']] = $count[0]['genre_count'];
                    }
                }
            }

            if (count(array_diff($genre_array, array_keys($genre_counts_array))) === 0) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 19;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //At least 20 completed story games.
        if (!in_array(20, $awarded_array)) {
            if ($game_count >= 20) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 20;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //One story published to the front page.
        if (!in_array(21, $awarded_array)) {
            if (!isset($front_page_count)) {
                App::import('model', 'Story');
                $Story = new Story();
                $front_page_count = $Story->find('count', array('conditions' => "user_id = {$id} and front_page = 1"));
            }
            if ($front_page_count >= 1) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 21;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //Two stories published to the front page.
        if (!in_array(22, $awarded_array)) {
            if (!isset($front_page_count)) {
                App::import('model', 'Story');
                $Story = new Story();
                $front_page_count = $Story->find('count', array('conditions' => "user_id = {$id} and front_page = 1"));
            }
            if ($front_page_count >= 2) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 22;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }

        //Three or more stories published to the front page.
        if (!in_array(23, $awarded_array)) {
            if (!isset($front_page_count)) {
                App::import('model', 'Story');
                $Story = new Story();
                $front_page_count = $Story->find('count', array('conditions' => "user_id = {$id} and front_page = 1"));
            }
            if ($front_page_count >= 3) {
                $data = array();
                $data['UserAward']['user_id'] = $id;
                $data['UserAward']['award_id'] = 23;
                $UserAward->create();
                $UserAward->save($data);
                $UserAward->clear();
            }
        }
    }
}
