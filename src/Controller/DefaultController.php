<?php

/**
 * instride AG.
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that is distributed with this source code.
 *
 * @copyright  Copyright (c) 2025 instride AG (https://instride.ch)
 */

declare(strict_types=1);

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Version;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FrontendController
{
    public function defaultAction(): Response
    {
        return $this->render('default/default.html.twig', [
            'version' => Version::getVersion(),
        ]);
    }

    public function legalsAction(): Response
    {
        return $this->render('default/legals.html.twig');
    }
}
