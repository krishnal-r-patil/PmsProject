<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AI Gram-Sahayak Global Injector
 * Automatically injects the high-fidelity AI widget into EVERY page on the site.
 * This solves the "UI not working" issue caused by inconsistent sidebars.
 */
class AiAssistantFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // No action needed before
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $session = session();
        
        // ONLY inject if the user is logged in
        if (!$session->get('user_id')) {
            return;
        }

        $contentType = $response->getHeaderLine('Content-Type');
        
        // Only inject into HTML pages, not JSON or AJAX requests
        if (strpos($contentType, 'text/html') === false) {
            return;
        }

        $body = $response->getBody();
        
        // Don't inject if already exists or on login/logout
        if (strpos($body, 'ult-sahayak-widget') !== false) {
            return;
        }

        // The widget HTML to inject
        $widgetHtml = view('partials/ai_assistant_widget');
        
        // Inject before the closing body tag
        $newBody = str_replace('</body>', $widgetHtml . '</body>', $body);
        
        $response->setBody($newBody);
    }
}
