<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Eccube\Tests\Web\Admin\Product;

use Eccube\Repository\TagRepository;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;

class TagContorllerTest extends AbstractAdminWebTestCase
{
    public function testRouting()
    {
        $this->client->request('GET', $this->generateUrl('admin_product_tag'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testUp()
    {
        $tagId = 3;
        $Item = $this->container->get(TagRepository::class)->find($tagId);
        $before = $Item->getSortNo();
        $this->client->request('PUT',
            $this->generateUrl('admin_product_tag_up', array('id' => $tagId))
        );
        $this->assertTrue($this->client->getResponse()->isRedirection());

        $after = $Item->getSortNo();
        $this->actual = $after;
        $this->expected = $before + 1;
        $this->verify();
    }

    public function testDown()
    {
        $tagId = 1;
        $Item = $this->container->get(TagRepository::class)->find($tagId);
        $before = $Item->getSortNo();
        $this->client->request('PUT',
            $this->generateUrl('admin_product_tag_down', array('id' => $tagId))
        );

        $this->assertTrue($this->client->getResponse()->isRedirection());

        $after = $Item->getSortNo();
        $this->actual = $after;
        $this->expected = $before - 1;
        $this->verify();
    }
}
