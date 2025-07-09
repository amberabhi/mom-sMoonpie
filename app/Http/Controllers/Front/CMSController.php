<?php

namespace App\Http\Controllers\Front;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CMSController extends Controller
{
    public function privacyPolicy()
    {
        $page = CmsPage::where('slug', 'privacy-policy')->latest()->first();

        return view('front.privacy-policy', compact('page'));
    }

	public function shippingPolicy()
    {
        $page = CmsPage::where('slug', 'shipping-policy')->latest()->first();

        return view('front.shipping-policy', compact('page'));
    }

	public function termsAndConditions()
    {
        $page = CmsPage::where('slug', 'terms-conditions')->latest()->first();

        return view('front.terms-and-conditions', compact('page'));
    }

	public function returnsPolicy()
    {
        $page = CmsPage::where('slug', 'returns-policy')->latest()->first();

        return view('front.returns-policy', compact('page'));
    }

	public function contactUs()
    {
        $page = CmsPage::where('slug', 'contact-us')->latest()->first();

        return view('front.contact-us', compact('page'));
    }

    public function aboutUs()
    {
        $page = CmsPage::where('slug', 'about-us')->latest()->first();

        return view('front.about-us', compact('page'));
    }
}
