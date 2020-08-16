<?php

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2020 (original work) Open Assessment Technologies SA;
 */

declare(strict_types=1);

namespace OAT\Library\Lti1p3Nrps\Membership;

use OAT\Library\Lti1p3Core\Exception\LtiException;
use OAT\Library\Lti1p3Core\User\UserIdentityFactory;
use OAT\Library\Lti1p3Core\User\UserIdentityFactoryInterface;
use OAT\Library\Lti1p3Core\User\UserIdentityInterface;
use OAT\Library\Lti1p3Nrps\Context\Context;
use OAT\Library\Lti1p3Nrps\Member\Member;
use OAT\Library\Lti1p3Nrps\Member\MemberInterface;
use RuntimeException;
use Throwable;

class MembershipSerializerOld
{
    /** @var UserIdentityFactoryInterface */
    private $userIdentityFactory;

    public function __construct(UserIdentityFactoryInterface $userIdentityFactory = null)
    {
        $this->userIdentityFactory = $userIdentityFactory ?? new UserIdentityFactory();
    }

    public function serialize(MembershipInterface $membership): string
    {
        $normalisation = [
            'id' => $membership->getIdentifier(),
            'context' => [
                'id' => $membership->getContext()->getIdentifier(),
                'label' => $membership->getContext()->getLabel(),
                'title' => $membership->getContext()->getTitle(),
            ]
        ];

        $membersNormalisation = [];
        /** @var MemberInterface $member */
        foreach ($membership->getMembers() as $member) {
            $membersNormalisation[] = [
                'user_id' => $member->getUserIdentity()->getIdentifier(),
                'name' => $member->getUserIdentity()->getName(),
                'email' => $member->getUserIdentity()->getEmail(),
                'given_name' => $member->getUserIdentity()->getGivenName(),
                'family_name' => $member->getUserIdentity()->getFamilyName(),
                'middle_name' => $member->getUserIdentity()->getMiddleName(),
                'locale' => $member->getUserIdentity()->getLocale(),
                'picture' => $member->getUserIdentity()->getPicture()
            ];
        }

        $normalisation['members'] = $membersNormalisation;

        return json_encode(array_filter($normalisation));
    }

    /**
     * @throws LtiException
     */
    public function deserialize(string $jsonData): MembershipInterface
    {
        try {
            $data = json_decode($jsonData, true);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new RuntimeException(
                    sprintf('Error during membership deserialization (json_decode): %s', json_last_error_msg())
                );
            }

            $context = new Context(
                $data['context']['id'],
                $data['context']['label'] ?? null,
                $data['context']['title'] ?? null
            );

            $membership = new Membership($data['id'], $context);

            foreach ($data['members'] ?? [] as $memberData) {
                $memberUserIdentity = $this->createMemberUserIdentity($memberData);

                $member = new Member(
                    $memberUserIdentity,
                    $memberData['status'] ?? MemberInterface::STATUS_ACTIVE,
                    $memberData['roles'] ?? [],
                    array_diff_assoc($memberData, $memberUserIdentity->normalize())
                );

                $membership->addMember($member);
            }

            return $membership;

        } catch (Throwable $exception) {
            throw new LtiException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
