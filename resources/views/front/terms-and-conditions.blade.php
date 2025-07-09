@extends('layouts.front')
@section('style')
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="comn-title-text mb-5 mt-3 text-center">Terms & <span>Conditions</span></h2>
            <div class="row">
                {!! $page->content !!}
				{{-- <p>Welcome to Mom's Moonpie! By shopping on our website or placing an order, you agree to the following terms and conditions:
                    Please read these terms and conditions ("terms and conditions", "terms") carefully
                    before using [www.momsmoonpie.com] website (“momsmoonpie.com”, “e-commerce”) operated by [Mom’s Moonpie]
                    ("us", 'we", "our").
                    Conditions of use
                    By using this website, you certify that you have read and reviewed this Agreement and
                    that you agree to comply with its terms. If you do not want to be bound by the terms of
                    this Agreement, you are advised to stop using the website accordingly. [Mom’s Moonpie]
                    only grants use and access of this website, its products, and its services to those who
                    have accepted its terms.
                    Privacy policy
                    Before you continue using our website, we advise you to read our <a href="https://momsmoonpie.com/privacy-policy" target="_blank">Privacy Policy</a> regarding our user data collection. It will help you better understand our
                    practices.
                    Age restriction
                    You must be at least 18 (eighteen) years of age before you can use this website. By
                    using this website, you warrant that you are at least 18 years of age and you may
                    legally adhere to this Agreement. [Mom’s Moonpie] assumes no responsibility for
                    liabilities related to age misrepresentation.
                    Intellectual property
                    You agree that all materials, products, and services provided on this website are the
                    property of [Mom’s Moonpie], its affiliates, directors, officers, employees, agents,
                    suppliers, or licensors including all copyrights, trade secrets, trademarks, patents, and
                    other intellectual property. You also agree that you will not reproduce or redistribute the
                    [Mom’s Moonpie]’s intellectual property in any way, including electronic, digital, or new
                    trademark registrations.
                    You grant [Mom’s Moonpie] a royalty-free and non-exclusive license to display, use,
                    copy, transmit, and broadcast the content you upload and publish. For issues regarding
                    intellectual property claims, you should contact the company in order to come to an
                    agreement.
                    User accounts
                    As a user of this website, you may be asked to register with us and provide private
                    information. You are responsible for ensuring the accuracy of this information, and you
                    are responsible for maintaining the safety and security of your identifying information. 

                    You are also responsible for all activities that occur under your account or password.
                    If you think there are any possible issues regarding the security of your account on the
                    website, inform us immediately so we may address them accordingly.
                    We reserve all rights to terminate accounts, edit or remove content and cancel orders at
                    our sole discretion.
                    Applicable law
                    By using this website, you agree that the laws of the [Maharashtra], without regard to
                    principles of conflict laws, will govern these terms and conditions, or any dispute of any
                    sort that might come between [Mom’s Moonpie] and you, or its business partners and
                    associates.
                    Disputes
                    Any dispute related in any way to your use of this website or to products you purchase
                    from us shall be arbitrated by state or federal court [Maharashtra] and you consent to
                    exclusive jurisdiction and venue of such courts.
                    Indemnification
                    You agree to indemnify [Mom’s Moonpie] and its affiliates and hold [Mom’s Moonpie]
                    harmless against legal claims and demands that may arise from your use or misuse of
                    our services. We reserve the right to select our own legal counsel.
                    Limitation on liability
                    [Mom’s Moonpie] is not liable for any damages that may occur to you as a result of your
                    misuse of our website.
                    [Mom’s Moonpie] reserves the right to edit, modify, and change this Agreement at any
                    time. We shall let our users know of these changes through electronic mail. This
                    Agreement is an understanding between [Mom’s Moonpie] and the user, and this
                    supersedes and replaces all prior agreements regarding the use of this website.
                </p> --}}
            </div>
        </div>
    </section>
    <!-- content -->
@endsection
