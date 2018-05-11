<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'error_prefix' => '',
    'error_suffix' => '',
    'loginForm' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    ),
    'passwordForm' => array(
       array(
            'field' => 'userName',
            'label' => 'Username',
            'rules' => 'trim'
        ),
    		array(
    				'field' => 'email',
    				'label' => 'Email address',
    				'rules' => 'trim'
    		)
    ),
    'emailUnique' => array(
        array(
            'field' => 'emailAddress',
            'label' => 'Email address',
            'rules' => 'trim|required|is_unique[user.emailAddress]'
        ),
    ),
    'usernameUnique' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|is_unique[user.username]'
        )
    ),
    'registerForm' => array(
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|is_unique[user.username]'
        ),
        array(
            'field' => 'emailAddress',
            'label' => 'Email address',
            'rules' => 'trim|required|is_unique[user.emailAddress]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    ),
	'viewquestionForm' => array(
        array(
            'field' => 'questionID',
            'label' => 'Question ID',
            'rules' => 'trim|required'
        ),
    ),
		
		'updateUserImage' => array(
				array(
						'field' => 'userGroup',
						'label' => 'User or Group',
						'rules' => 'trim|required'
				),
				 array(
						'field' => 'usergroupID',
						'label' => 'User ID or Group ID ',
						'rules' => 'trim'
				)
		),
		'commentForm' => array(
				array(
						'field' => 'questionID',
						'label' => 'Question ID',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'comment',
						'label' => 'Comment',
						'rules' => 'trim|required'
				),array(
						'field' => 'parent_comment_id',
						'label' => 'Parent comment id',
						'rules' => 'trim'
				)
				
		),
		'ratingForm' => array(
				array(
						'field' => 'questionID',
						'label' => 'Question ID',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'commentID',
						'label' => 'Comment ID',
						'rules' => 'trim|required'
				),array(
						'field' => 'rating',
						'label' => 'Rating',
						'rules' => 'trim'
				)
		),
		'creatGroup' => array(
		              array(
						'field' => 'groupName',
						'label' => 'usergroupName',
						'rules' => 'trim|required'
				),
		),
		'groupMessage' => array(
				array(
						'field' => 'groupID',
						'label' => 'groupName',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'groupMessage',
						'label' => 'Message',
						'rules' => 'trim|required'
				),
				
		),
		'addmember' => array(
				array(
						'field' => 'groupId',
						'label' => 'Group Name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'selectedUser',
						'label' => 'User name',
						'rules' => 'trim|required'
				),
				
		),
		'registerForm' => array(
				array(
						'field' => 'firstName',
						'label' => 'First Name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'middleName',
						'label' => 'Middle Name',
						'rules' => 'trim'
				),
				array(
						'field' => 'lastName',
						'label' => 'Last name',
						'rules' => 'trim|required'
				),
		
				array(
						'field' => 'userName',
						'label' => 'Username',
						'rules' => 'trim|required|is_unique[user_master.user_id]'
				),
				array(
						'field' => 'emailAddress',
						'label' => 'Email address',
						'rules' => 'trim|required|is_unique[user_master.email_1]'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required'
				),
		
				array(
						'field' => 'telephone',
						'label' => 'Telephone Number',
						'rules' => 'trim'
				),
				array(
						'field' => 'tutorType',
						'label' => 'Tutor Type',
						'rules' => 'trim|required'
				),
		
		),
		'postquestion' => array(
				array(
						'field' => 'title',
						'label' => 'Title',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'description',
						'label' => 'Description',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'Category',
						'label' => 'Category',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'SubCategory',
						'label' => 'subCategory',
						'rules' => 'trim|required'
				)
		),
		'postMessage' => array(
				array(
						'field' => 'message',
						'label' => 'Message',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'userId',
						'label' => 'User Id',
						'rules' => 'trim|required'
				)
				
		),
		
		'updateUserInfo' => array(
				array(
						'field' => 'f_name',
						'label' => 'First Name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'm_name',
						'label' => 'Middle Name',
						'rules' => 'trim'
				),
				array(
						'field' => 'l_name',
						'label' => 'Last Name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'email',
						'label' => 'Email Address',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'altEmail',
						'label' => 'Alternative Email Address',
						'rules' => 'trim'
				),
				array(
						'field' => 'mobile',
						'label' => 'Mobile',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'telephone',
						'label' => 'Telephone',
						'rules' => 'trim'
				),
				array(
						'field' => 'screen_name',
						'label' => 'Screen Name',
						'rules' => 'trim'
				)
		),
		'resetpassword' => array(
				array(
						'field' => 'userId',
						'label' => 'Password',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'newpassword',
						'label' => 'newPassword',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'confirmpassword',
						'label' => 'confirmPassword',
						'rules' => 'trim|required'
				)
				)
		
);

