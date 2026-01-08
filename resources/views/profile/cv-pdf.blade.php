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
            font-size: 10pt;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        /* Header with photo */
        .header {
            background: linear-gradient(135deg, #0040A0 0%, #5AC8FA 100%);
            color: white;
            padding: 30px;
            margin-bottom: 20px;
            position: relative;
        }

        .header-with-photo {
            padding-right: 130px;
        }

        .header-photo {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 100px;
            height: 100px;
        }

        .header-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }

        .name {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12pt;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .contact-info {
            font-size: 9pt;
            margin-top: 10px;
        }

        .contact-info div {
            margin-bottom: 3px;
        }

        /* Sections */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #0040A0;
            color: white;
            padding: 8px 15px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .section-content {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Items */
        .item {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .item-header {
            margin-bottom: 5px;
            overflow: hidden;
        }

        .item-title {
            font-weight: bold;
            font-size: 11pt;
            color: #0040A0;
            float: left;
            width: 70%;
        }

        .item-date {
            float: right;
            color: #666;
            font-size: 9pt;
            text-align: right;
            width: 30%;
        }

        .item-subtitle {
            font-style: italic;
            color: #666;
            margin-bottom: 3px;
            clear: both;
        }

        .item-description {
            text-align: justify;
            margin-top: 5px;
            clear: both;
        }

        /* Skills grid */
        .skill-item {
            margin-bottom: 8px;
        }

        .skill-category {
            font-weight: bold;
            color: #0040A0;
        }

        /* Languages */
        .language-item {
            margin-bottom: 5px;
            overflow: hidden;
        }

        .language-name {
            font-weight: bold;
            float: left;
            width: 60%;
        }

        .language-level {
            float: right;
            color: #666;
            text-align: right;
            width: 40%;
        }

        /* Publications */
        .publication-item {
            margin-bottom: 10px;
            text-align: justify;
        }

        .publication-title {
            font-weight: bold;
            color: #0040A0;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        /* Page break control */
        .page-break {
            page-break-after: always;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header {{ $user->profile_photo ? 'header-with-photo' : '' }}">
            @if($user->profile_photo)
                <div class="header-photo">
                    <img src="{{ public_path('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                </div>
            @endif
            <div class="name">{{ $user->name }}</div>
            <div class="subtitle">
                @if($user->grade)
                    {{ $user->grade }}
                @endif
                @if($user->institution)
                    @if($user->grade) - @endif
                    {{ $user->institution }}
                @endif
            </div>
            <div class="contact-info">
                <div><strong>Email:</strong> {{ $user->email }}</div>
                @if($user->phone)
                    <div><strong>Téléphone:</strong> {{ $user->phone }}</div>
                @endif
                @if($user->address)
                    <div><strong>Adresse:</strong> {{ $user->address }}</div>
                @endif
                @if($user->linkedin)
                    <div><strong>LinkedIn:</strong> {{ $user->linkedin }}</div>
                @endif
            </div>
        </div>

        <!-- Bio / Profil -->
        @if($user->bio)
            <div class="section">
                <div class="section-title">Profil</div>
                <div class="section-content">
                    <p style="text-align: justify;">{{ $user->bio }}</p>
                </div>
            </div>
        @endif

        <!-- Formation académique -->
        @if($user->education && count($user->education) > 0)
            <div class="section">
                <div class="section-title">Formation académique</div>
                <div class="section-content">
                    @foreach($user->education as $edu)
                        <div class="item">
                            <div class="item-header clearfix">
                                <div class="item-title">{{ $edu['degree'] ?? '' }}</div>
                                <div class="item-date">
                                    {{ $edu['start_date'] ?? '' }}
                                    @if(isset($edu['end_date']) && $edu['end_date'])
                                        - {{ $edu['end_date'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="item-subtitle">
                                {{ $edu['institution'] ?? '' }}
                                @if(isset($edu['location']) && $edu['location'])
                                    - {{ $edu['location'] }}
                                @endif
                            </div>
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
                <div class="section-title">Expérience professionnelle</div>
                <div class="section-content">
                    @foreach($user->experience as $exp)
                        <div class="item">
                            <div class="item-header clearfix">
                                <div class="item-title">{{ $exp['position'] ?? '' }}</div>
                                <div class="item-date">
                                    {{ $exp['start_date'] ?? '' }}
                                    @if(isset($exp['end_date']) && $exp['end_date'])
                                        - {{ $exp['end_date'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="item-subtitle">
                                {{ $exp['company'] ?? '' }}
                                @if(isset($exp['location']) && $exp['location'])
                                    - {{ $exp['location'] }}
                                @endif
                            </div>
                            @if(isset($exp['description']) && $exp['description'])
                                <div class="item-description">{{ $exp['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Compétences -->
        @if($user->skills && count($user->skills) > 0)
            <div class="section">
                <div class="section-title">Compétences</div>
                <div class="section-content">
                    @foreach($user->skills as $skill)
                        <div class="skill-item">
                            <span class="skill-category">{{ $skill['category'] ?? '' }}:</span>
                            {{ $skill['items'] ?? '' }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Langues -->
        @if($user->languages && count($user->languages) > 0)
            <div class="section">
                <div class="section-title">Langues</div>
                <div class="section-content">
                    @foreach($user->languages as $lang)
                        <div class="language-item clearfix">
                            <div class="language-name">{{ $lang['language'] ?? '' }}</div>
                            <div class="language-level">{{ $lang['level'] ?? '' }}</div>
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
                    @foreach($user->publications as $pub)
                        <div class="publication-item">
                            <div class="publication-title">{{ $pub['title'] ?? '' }}</div>
                            <div>
                                @if(isset($pub['authors']) && $pub['authors'])
                                    {{ $pub['authors'] }}.
                                @endif
                                @if(isset($pub['year']) && $pub['year'])
                                    ({{ $pub['year'] }}).
                                @endif
                                @if(isset($pub['journal']) && $pub['journal'])
                                    <em>{{ $pub['journal'] }}</em>.
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

        <!-- Certifications -->
        @if($user->certifications && count($user->certifications) > 0)
            <div class="section">
                <div class="section-title">Certifications et distinctions</div>
                <div class="section-content">
                    @foreach($user->certifications as $cert)
                        <div class="item">
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
                        <div class="item">
                            <div class="item-title">{{ $ref['name'] ?? '' }}</div>
                            <div class="item-subtitle">
                                {{ $ref['position'] ?? '' }}
                                @if(isset($ref['organization']) && $ref['organization'])
                                    - {{ $ref['organization'] }}
                                @endif
                            </div>
                            @if(isset($ref['email']) && $ref['email'])
                                <div>Email: {{ $ref['email'] }}</div>
                            @endif
                            @if(isset($ref['phone']) && $ref['phone'])
                                <div>Tél: {{ $ref['phone'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        CV généré via ArEM - École Normale Supérieure de Maroua - {{ date('d/m/Y') }}
    </div>
</body>
</html>
