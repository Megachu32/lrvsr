@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h2 class="fw-bold"><i class="fa-solid fa-scale-balanced text-primary me-2"></i> Content Policy</h2>
                    <p class="text-secondary">These are the rules that apply to everyone on RedditClone. Violating these may result in a ban.</p>
                </div>

                <div class="card-body px-4 pb-4">
                    <div class="accordion" id="rulesAccordion">
                        
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold collapsed bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#rule1">
                                    1. Remember the human
                                </button>
                            </h2>
                            <div id="rule1" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                <div class="accordion-body text-secondary small">
                                    Reddit is a place for creating community and belonging, not for attacking marginalized or vulnerable groups of people. Everyone has a right to use Reddit free of harassment, bullying, and threats of violence.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold collapsed bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#rule2">
                                    2. Abide by community rules
                                </button>
                            </h2>
                            <div id="rule2" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                <div class="accordion-body text-secondary small">
                                    Post authentic content into communities where you have a personal interest, and do not cheat or engage in content manipulation (including spamming, vote manipulation, ban evasion, or subscriber fraud).
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold collapsed bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#rule3">
                                    3. Respect the privacy of others
                                </button>
                            </h2>
                            <div id="rule3" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                <div class="accordion-body text-secondary small">
                                    Instigating harassment, for example by revealing someone’s personal or confidential information, is not allowed. Never post intimate or sexually-explicit media of someone without their consent.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold collapsed bg-white text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#rule4">
                                    4. Do not post illegal content
                                </button>
                            </h2>
                            <div id="rule4" class="accordion-collapse collapse" data-bs-parent="#rulesAccordion">
                                <div class="accordion-body text-secondary small">
                                    Keep it legal, and avoid posting illegal content or soliciting or facilitating illegal or prohibited transactions.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-none d-md-block">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-danger text-white fw-bold">
                    <i class="fa-solid fa-gavel me-2"></i> Enforcement
                </div>
                <div class="card-body">
                    <p class="card-text small text-secondary">We have a variety of ways of enforcing our rules, including, but not limited to:</p>
                    <ul class="small text-secondary ps-3 mb-0">
                        <li>Asking you nicely to stop</li>
                        <li>Temporary or permanent account bans</li>
                        <li>Removal of privileges</li>
                        <li>Adding restrictions to accounts</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">Need help?</h6>
                    <p class="small text-secondary">If you are unsure if your content violates the rules, please contact the administrators before posting.</p>
                    <button class="btn btn-outline-secondary w-100 rounded-pill btn-sm">Contact Support</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection