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
						'rules' => 'trim'
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
		'categoryform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				)
		),
		'categoryupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'subcategoryform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'category_id',
						'label' => 'categoryid',
						'rules' => 'trim|required'
				)
		),
		'subcategoryupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'category_id',
						'label' => 'category_id',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'countryform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				)
		),
		'countryupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'stateform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'code',
						'label' => 'code',
						'rules' => 'trim|required'
						),
				array(
						'field' => 'country_id',
						'label' => 'countryid',
						'rules' => 'trim|required'
				)
		),
		'stateupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'code',
						'label' => 'code',
						'rules' => 'trim'
				),
				array(
						'field' => 'country_id',
						'label' => 'country_id',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'districtform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
				
				array(
						'field' => 'state_id',
						'label' => 'stateid',
						'rules' => 'trim|required'
				)
		),
		'districtupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				
				array(
						'field' => 'state_id',
						'label' => 'state_id',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		
		'cityform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
		
				array(
						'field' => 'state_id',
						'label' => 'stateid',
						'rules' => 'trim|required'
				)
		),
		'cityupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
		
				array(
						'field' => 'state_id',
						'label' => 'state_id',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'countyform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
		
				array(
						'field' => 'state_id',
						'label' => 'stateid',
						'rules' => 'trim|required'
				)
		),
		'countyupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
		
				array(
						'field' => 'state_id',
						'label' => 'state_id',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		
		'schoolform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'state_id',
						'label' => 'state_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'country_id',
						'label' => 'countryid',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'district_id',
						'label' => 'district_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'city_id',
						'label' => 'city_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'county_id',
						'label' => 'county_id',
						'rules' => 'trim|required'
				)
		),
		'schoolupdateform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'state_id',
						'label' => 'state_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'country_id',
						'label' => 'countryid',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'district_id',
						'label' => 'district_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'city_id',
						'label' => 'city_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'county_id',
						'label' => 'county_id',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'tutorform' => array(
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim|required'
				)
		),
		'tutorupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'gradeform' => array(
				array(
						'field' => 'percentage_from',
						'label' => 'percentage_from',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'percentage_to',
						'label' => 'percentage_to',
						'rules' => 'trim'
				)
		),
		'gradeupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'from',
						'label' => 'percentage from',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'to',
						'label' => 'percentage to',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		
		'tutorupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim'
				),
				array(
						'field' => 'name',
						'label' => 'name',
						'rules' => 'trim'
				),
				array(
						'field' => 'percentage_from',
						'label' => 'percentage_from',
						'rules' => 'trim'
				),
				array(
						'field' => 'percentage_to',
						'label' => 'percentage_to',
						'rules' => 'trim'
				),
				array(
						'field' => 'isActive',
						'label' => 'status',
						'rules' => 'trim'
				)
		),
		'userdetailsupdateform' => array(
				array(
						'field' => 'id',
						'label' => 'id',
						'rules' => 'trim|required'
				),
		
				array(
						'field' => 'isActive',
						'label' => 'isActive',
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

