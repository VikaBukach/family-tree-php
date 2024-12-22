<?php
namespace FamilyTree\structure;

class FamilyRelationshipsStructure
{
    public function __construct(
        public $member_id,
        public $memeber_name,
        public $memeber_surname,
        public $memeber_avatar,
        public $role_name,
        public $related_name,
        public $related_surname,
        public $related_avatar
    ) {}
}