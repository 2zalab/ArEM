<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #333;
            line-height: 1.4;
        }

        .container {
            width: 100%;
        }

        /* Two-column layout using floats */
        .sidebar {
            float: left;
            width: 32%;
            background-color: #f8f9fa;
            min-height: 800px;
            padding: 0;
        }

        .main-content {
            float: right;
            width: 66%;
            padding: 20px;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Sidebar styles */
        .sidebar-photo {
            width: 100%;
            text-align: center;
            padding: 25px 20px;
            background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
        }

        .sidebar-photo img {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            border: 4px solid white;
            object-fit: cover;
        }

        .sidebar-section {
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .sidebar-section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0040A0;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #0040A0;
            padding-bottom: 5px;
        }

        .info-item {
            margin-bottom: 8px;
            word-wrap: break-word;
        }

        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 8pt;
            display: block;
            margin-bottom: 2px;
        }

        .info-value {
            color: #333;
            font-size: 9pt;
        }

        .skill-item {
            margin-bottom: 8px;
        }

        .skill-name {
            font-weight: bold;
            color: #333;
            font-size: 9pt;
            margin-bottom: 3px;
        }

        .skill-dots {
            margin-top: 3px;
        }

        .skill-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 5px;
            background-color: #0040A0;
            margin-right: 3px;
        }

        .skill-dot-empty {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 5px;
            border: 1px solid #0040A0;
            background-color: transparent;
            margin-right: 3px;
        }

        /* Main content styles */
        .header-main {
            background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
            color: white;
            padding: 20px;
            margin: -20px -20px 20px -20px;
        }

        .header-name {
            font-size: 20pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-subtitle {
            font-size: 11pt;
            opacity: 0.9;
        }

        /* Sections */
        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #0040A0;
            border-bottom: 2px solid #0040A0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .section-content {
            padding-left: 5px;
        }

        /* Profile */
        .profile-text {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        /* Items */
        .cv-item {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .item-header {
            margin-bottom: 3px;
            overflow: hidden;
        }

        .item-title {
            font-weight: bold;
            font-size: 10pt;
            color: #0040A0;
            float: left;
            width: 65%;
        }

        .item-date {
            float: right;
            color: #666;
            font-size: 8pt;
            text-align: right;
            width: 35%;
            font-style: italic;
        }

        .item-subtitle {
            color: #666;
            font-size: 9pt;
            margin-bottom: 3px;
            clear: both;
            font-style: italic;
        }

        .item-location {
            color: #888;
            font-size: 8pt;
            margin-bottom: 3px;
        }

        .item-description {
            text-align: justify;
            margin-top: 4px;
            clear: both;
            font-size: 9pt;
        }

        /* Publications */
        .publication-item {
            margin-bottom: 10px;
            text-align: justify;
            font-size: 8.5pt;
        }

        .publication-title {
            font-weight: bold;
            color: #0040A0;
        }

        .publication-details {
            color: #666;
        }

        /* References */
        .reference-item {
            margin-bottom: 10px;
        }

        .reference-name {
            font-weight: bold;
            color: #0040A0;
            font-size: 9pt;
        }

        .reference-position {
            font-style: italic;
            color: #666;
            font-size: 8pt;
        }

        .reference-contact {
            font-size: 8pt;
            color: #666;
        }

        /* Languages */
        .language-item {
            margin-bottom: 5px;
            overflow: hidden;
        }

        .language-name {
            font-weight: bold;
            float: left;
            width: 50%;
        }

        .language-level {
            float: right;
            color: #666;
            text-align: right;
            width: 50%;
            font-size: 8pt;
        }

        /* Social links */
        .social-link {
            color: #0040A0;
            text-decoration: none;
            font-size: 8pt;
            word-break: break-all;
        }

        /* Page break control */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="container clearfix">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <!-- Photo -->
            @if($user->profile_photo)
                <div class="sidebar-photo">
                    <img src="{{ public_path('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                </div>
            @endif

            <!-- Personal Informations -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Informations</div>

                <div class="info-item">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>

                @if($user->email)
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                @endif

                @if($user->phone)
                    <div class="info-item">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $user->phone }}</span>
                    </div>
                @endif

                @if($user->address)
                    <div class="info-item">
                        <span class="info-label">Adresse</span>
                        <span class="info-value">{{ $user->address }}</span>
                    </div>
                @endif

                @if($user->birth_date)
                    <div class="info-item">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value">{{ $user->birth_date->format('d/m/Y') }}</span>
                    </div>
                @endif

                @if($user->birth_place)
                    <div class="info-item">
                        <span class="info-label">Lieu de naissance</span>
                        <span class="info-value">{{ $user->birth_place }}</span>
                    </div>
                @endif

                @if($user->nationality)
                    <div class="info-item">
                        <span class="info-label">Nationalité</span>
                        <span class="info-value">{{ $user->nationality }}</span>
                    </div>
                @endif
            </div>

            <!-- Social Links -->
            @if($user->linkedin || $user->orcid || $user->google_scholar)
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Liens</div>

                    @if($user->linkedin)
                        <div class="info-item">
                            <span class="info-label">LinkedIn</span>
                            <a href="{{ $user->linkedin }}" class="social-link">{{ $user->linkedin }}</a>
                        </div>
                    @endif

                    @if($user->orcid)
                        <div class="info-item">
                            <span class="info-label">ORCID</span>
                            <span class="info-value">{{ $user->orcid }}</span>
                        </div>
                    @endif

                    @if($user->google_scholar)
                        <div class="info-item">
                            <span class="info-label">Google Scholar</span>
                            <a href="{{ $user->google_scholar }}" class="social-link">Profil</a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Compétences -->
            @if($user->skills && count($user->skills) > 0)
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Compétences</div>
                    @foreach($user->skills as $skill)
                        <div class="skill-item">
                            <div class="skill-name">{{ $skill['category'] ?? '' }}</div>
                            <div class="skill-dots">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < 4)
                                        <span class="skill-dot"></span>
                                    @else
                                        <span class="skill-dot-empty"></span>
                                    @endif
                                @endfor
                            </div>
                            @if(isset($skill['items']) && $skill['items'])
                                <div style="font-size: 8pt; color: #666; margin-top: 2px;">{{ $skill['items'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Langues -->
            @if($user->languages && count($user->languages) > 0)
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Langues</div>
                    @foreach($user->languages as $lang)
                        <div class="language-item clearfix">
                            <div class="language-name">{{ $lang['language'] ?? '' }}</div>
                            <div class="language-level">{{ $lang['level'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Main Content -->
        <div class="main-content">
            <!-- Header with name -->
            <div class="header-main">
                <div class="header-name">{{ $user->name }}</div>
                <div class="header-subtitle">
                    @if($user->grade)
                        {{ $user->grade }}
                    @endif
                    @if($user->institution)
                        @if($user->grade), @endif
                        {{ $user->institution }}
                    @endif
                    @if($user->user_type)
                        @if($user->grade || $user->institution) - @endif
                        {{ ucfirst($user->user_type) }}
                    @endif
                </div>
            </div>

            <!-- Profile / Bio -->
            @if($user->bio)
                <div class="section no-break">
                    <div class="section-title">Profil</div>
                    <div class="section-content">
                        <p class="profile-text">{{ $user->bio }}</p>
                    </div>
                </div>
            @endif

            <!-- Formation académique -->
            @if($user->education && count($user->education) > 0)
                <div class="section">
                    <div class="section-title">Education</div>
                    <div class="section-content">
                        @foreach($user->education as $edu)
                            <div class="cv-item">
                                <div class="item-header clearfix">
                                    <div class="item-title">{{ $edu['degree'] ?? '' }}</div>
                                    <div class="item-date">
                                        @if(isset($edu['start_date']) && $edu['start_date'])
                                            {{ $edu['start_date'] }}
                                            @if(isset($edu['end_date']) && $edu['end_date'])
                                                - {{ $edu['end_date'] }}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="item-subtitle">
                                    {{ $edu['institution'] ?? '' }}
                                </div>
                                @if(isset($edu['location']) && $edu['location'])
                                    <div class="item-location">{{ $edu['location'] }}</div>
                                @endif
                                @if(isset($edu['description']) && $edu['description'])
                                    <div class="item-description">{{ $edu['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Expérience professionnelle -->
            @if($user->experience && count($user->experience) > 0)
                <div class="section">
                    <div class="section-title">Experience Professionnelle</div>
                    <div class="section-content">
                        @foreach($user->experience as $exp)
                            <div class="cv-item">
                                <div class="item-header clearfix">
                                    <div class="item-title">{{ $exp['position'] ?? '' }}</div>
                                    <div class="item-date">
                                        @if(isset($exp['start_date']) && $exp['start_date'])
                                            {{ $exp['start_date'] }}
                                            @if(isset($exp['end_date']) && $exp['end_date'])
                                                - {{ $exp['end_date'] }}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="item-subtitle">
                                    {{ $exp['company'] ?? '' }}
                                </div>
                                @if(isset($exp['location']) && $exp['location'])
                                    <div class="item-location">{{ $exp['location'] }}</div>
                                @endif
                                @if(isset($exp['description']) && $exp['description'])
                                    <div class="item-description">{{ $exp['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Publications -->
            @if($user->publications && count($user->publications) > 0)
                <div class="section">
                    <div class="section-title">Publications</div>
                    <div class="section-content">
                        @foreach($user->publications as $index => $pub)
                            <div class="publication-item">
                                <span class="publication-title">{{ $pub['title'] ?? '' }}</span>
                                <div class="publication-details">
                                    @if(isset($pub['authors']) && $pub['authors'])
                                        {{ $pub['authors'] }}.
                                    @endif
                                    @if(isset($pub['year']) && $pub['year'])
                                        ({{ $pub['year'] }}).
                                    @endif
                                    @if(isset($pub['journal']) && $pub['journal'])
                                        <em>{{ $pub['journal'] }}</em>.
                                    @endif
                                    @if(isset($pub['type']) && $pub['type'])
                                        [{{ $pub['type'] }}].
                                    @endif
                                    @if(isset($pub['doi']) && $pub['doi'])
                                        DOI: {{ $pub['doi'] }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Certifications et distinctions -->
            @if($user->certifications && count($user->certifications) > 0)
                <div class="section">
                    <div class="section-title">Certifications & Distinctions</div>
                    <div class="section-content">
                        @foreach($user->certifications as $cert)
                            <div class="cv-item">
                                <div class="item-header clearfix">
                                    <div class="item-title">{{ $cert['name'] ?? '' }}</div>
                                    @if(isset($cert['year']) && $cert['year'])
                                        <div class="item-date">{{ $cert['year'] }}</div>
                                    @endif
                                </div>
                                @if(isset($cert['issuer']) && $cert['issuer'])
                                    <div class="item-subtitle">{{ $cert['issuer'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Références -->
            @if($user->references && count($user->references) > 0)
                <div class="section">
                    <div class="section-title">Références</div>
                    <div class="section-content">
                        @foreach($user->references as $ref)
                            <div class="reference-item">
                                <div class="reference-name">{{ $ref['name'] ?? '' }}</div>
                                <div class="reference-position">
                                    {{ $ref['position'] ?? '' }}
                                    @if(isset($ref['organization']) && $ref['organization'])
                                        - {{ $ref['organization'] }}
                                    @endif
                                </div>
                                @if(isset($ref['email']) && $ref['email'])
                                    <div class="reference-contact">Email: {{ $ref['email'] }}</div>
                                @endif
                                @if(isset($ref['phone']) && $ref['phone'])
                                    <div class="reference-contact">Tél: {{ $ref['phone'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
