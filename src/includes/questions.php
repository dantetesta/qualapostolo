<?php
// Quiz Questions - 20 Questões mapeadas para 6 eixos de personalidade

/**
 * Eixos de Scoring:
 * 1. leadership (0-100) — Liderança vs. Seguidores
 * 2. action (0-100) — Ação vs. Reflexão
 * 3. faith (0-100) — Fé Cega vs. Lógica
 * 4. innovation (0-100) — Inovação vs. Tradição
 * 5. community (0-100) — Comunidade vs. Solidão
 * 6. growth (0-100) — Crescimento vs. Estabilidade
 */

function getQuestions() {
    return [
        // Q1: Action vs Reflection
        [
            'id' => 1,
            'question' => 'Quando enfrenta um problema, você:',
            'answers' => [
                [
                    'text' => 'Age primeiro, reflete depois',
                    'scores' => ['action' => 90, 'faith' => 20, 'growth' => 80, 'leadership' => 70, 'community' => 40, 'innovation' => 60]
                ],
                [
                    'text' => 'Reflete bastante antes de agir',
                    'scores' => ['action' => 20, 'faith' => 80, 'growth' => 40, 'leadership' => 30, 'community' => 50, 'innovation' => 30]
                ],
                [
                    'text' => 'Busca conselhos de pessoas de confiança',
                    'scores' => ['action' => 50, 'faith' => 60, 'growth' => 50, 'leadership' => 30, 'community' => 90, 'innovation' => 40]
                ],
                [
                    'text' => 'Analisa profundamente antes de decidir',
                    'scores' => ['action' => 30, 'faith' => 70, 'growth' => 45, 'leadership' => 40, 'community' => 40, 'innovation' => 50]
                ]
            ]
        ],
        // Q2: Leadership
        [
            'id' => 2,
            'question' => 'Em um grupo, você naturalmente:',
            'answers' => [
                [
                    'text' => 'Assume o papel de líder',
                    'scores' => ['leadership' => 95, 'action' => 85, 'community' => 60, 'innovation' => 70, 'faith' => 60, 'growth' => 80]
                ],
                [
                    'text' => 'Segue quem tem visão clara',
                    'scores' => ['leadership' => 20, 'action' => 50, 'community' => 80, 'innovation' => 30, 'faith' => 70, 'growth' => 40]
                ],
                [
                    'text' => 'Colabora, mas não quer toda a responsabilidade',
                    'scores' => ['leadership' => 50, 'action' => 60, 'community' => 85, 'innovation' => 60, 'faith' => 50, 'growth' => 70]
                ],
                [
                    'text' => 'Prefere trabalhar de forma independente',
                    'scores' => ['leadership' => 60, 'action' => 70, 'community' => 30, 'innovation' => 80, 'faith' => 50, 'growth' => 60]
                ]
            ]
        ],
        // Q3: Faith vs Logic
        [
            'id' => 3,
            'question' => 'Você acredita mais em:',
            'answers' => [
                [
                    'text' => 'Intuição e fé — mesmo sem explicação racional',
                    'scores' => ['faith' => 95, 'action' => 80, 'growth' => 70, 'innovation' => 60, 'community' => 70, 'leadership' => 70]
                ],
                [
                    'text' => 'Dados, evidências e lógica pura',
                    'scores' => ['faith' => 10, 'action' => 60, 'growth' => 50, 'innovation' => 80, 'community' => 40, 'leadership' => 50]
                ],
                [
                    'text' => 'Equilíbrio entre fé e razão',
                    'scores' => ['faith' => 55, 'action' => 70, 'growth' => 65, 'innovation' => 60, 'community' => 60, 'leadership' => 60]
                ],
                [
                    'text' => 'Experiência pessoal e comprovação prática',
                    'scores' => ['faith' => 40, 'action' => 85, 'growth' => 75, 'innovation' => 70, 'community' => 50, 'leadership' => 60]
                ]
            ]
        ],
        // Q4: Community vs Solitude
        [
            'id' => 4,
            'question' => 'Para recarregar energia, você:',
            'answers' => [
                [
                    'text' => 'Gasta tempo com amigos e comunidade',
                    'scores' => ['community' => 95, 'growth' => 70, 'action' => 80, 'leadership' => 70, 'faith' => 70, 'innovation' => 50]
                ],
                [
                    'text' => 'Fica sozinho, refletindo e meditando',
                    'scores' => ['community' => 15, 'growth' => 40, 'action' => 30, 'leadership' => 30, 'faith' => 80, 'innovation' => 60]
                ],
                [
                    'text' => 'Precisa de um pouco de ambos',
                    'scores' => ['community' => 60, 'growth' => 70, 'action' => 70, 'leadership' => 50, 'faith' => 60, 'innovation' => 50]
                ],
                [
                    'text' => 'Depende da companhia — poucos amigos próximos',
                    'scores' => ['community' => 45, 'growth' => 60, 'action' => 60, 'leadership' => 50, 'faith' => 65, 'innovation' => 55]
                ]
            ]
        ],
        // Q5: Tradition vs Innovation
        [
            'id' => 5,
            'question' => 'Frente ao novo ou desconhecido, você:',
            'answers' => [
                [
                    'text' => 'Abraça a mudança com entusiasmo',
                    'scores' => ['innovation' => 95, 'growth' => 85, 'action' => 80, 'leadership' => 70, 'community' => 50, 'faith' => 40]
                ],
                [
                    'text' => 'Prefere manter o que já funciona',
                    'scores' => ['innovation' => 15, 'growth' => 35, 'action' => 40, 'leadership' => 40, 'community' => 70, 'faith' => 80]
                ],
                [
                    'text' => 'Testa antes de abandonar o antigo',
                    'scores' => ['innovation' => 60, 'growth' => 65, 'action' => 70, 'leadership' => 60, 'community' => 60, 'faith' => 50]
                ],
                [
                    'text' => 'Muda quando é absolutamente necessário',
                    'scores' => ['innovation' => 30, 'growth' => 45, 'action' => 50, 'leadership' => 50, 'community' => 65, 'faith' => 70]
                ]
            ]
        ],
        // Q6: Growth vs Stability
        [
            'id' => 6,
            'question' => 'Sua motivação principal é:',
            'answers' => [
                [
                    'text' => 'Crescer, evoluir, melhorar constantemente',
                    'scores' => ['growth' => 95, 'action' => 85, 'innovation' => 80, 'leadership' => 70, 'community' => 50, 'faith' => 60]
                ],
                [
                    'text' => 'Encontrar paz e estabilidade',
                    'scores' => ['growth' => 20, 'action' => 40, 'innovation' => 30, 'leadership' => 30, 'community' => 70, 'faith' => 80]
                ],
                [
                    'text' => 'Ajudar os outros a crescerem',
                    'scores' => ['growth' => 75, 'action' => 70, 'innovation' => 60, 'leadership' => 80, 'community' => 90, 'faith' => 70]
                ],
                [
                    'text' => 'Manter equilíbrio entre ambos',
                    'scores' => ['growth' => 60, 'action' => 70, 'innovation' => 55, 'leadership' => 60, 'community' => 65, 'faith' => 65]
                ]
            ]
        ],
        // Q7: Character (Strengths)
        [
            'id' => 7,
            'question' => 'Qual é sua maior força?',
            'answers' => [
                [
                    'text' => 'Determinação e coragem',
                    'scores' => ['action' => 90, 'leadership' => 85, 'growth' => 80, 'faith' => 70, 'community' => 50, 'innovation' => 60]
                ],
                [
                    'text' => 'Compaixão e empatia',
                    'scores' => ['community' => 95, 'faith' => 80, 'growth' => 70, 'leadership' => 50, 'action' => 50, 'innovation' => 40]
                ],
                [
                    'text' => 'Inteligência e análise',
                    'scores' => ['faith' => 30, 'action' => 60, 'innovation' => 80, 'leadership' => 60, 'community' => 40, 'growth' => 70]
                ],
                [
                    'text' => 'Autenticidade e sinceridade',
                    'scores' => ['faith' => 85, 'action' => 70, 'community' => 70, 'leadership' => 60, 'growth' => 75, 'innovation' => 50]
                ]
            ]
        ],
        // Q8: Weakness (Blind Spots)
        [
            'id' => 8,
            'question' => 'Seu maior desafio pessoal é:',
            'answers' => [
                [
                    'text' => 'Ser impulsivo ou impaciente',
                    'scores' => ['action' => 85, 'faith' => 30, 'growth' => 60, 'leadership' => 70, 'community' => 40, 'innovation' => 70]
                ],
                [
                    'text' => 'Duvidoso ou céticos demais',
                    'scores' => ['faith' => 20, 'action' => 50, 'growth' => 50, 'leadership' => 40, 'community' => 50, 'innovation' => 80]
                ],
                [
                    'text' => 'Dependência excessiva do que os outros pensam',
                    'scores' => ['community' => 80, 'leadership' => 30, 'growth' => 40, 'faith' => 60, 'action' => 40, 'innovation' => 30]
                ],
                [
                    'text' => 'Obsessão por detalhes ou perfeição',
                    'scores' => ['growth' => 55, 'action' => 50, 'faith' => 60, 'leadership' => 50, 'community' => 40, 'innovation' => 40]
                ]
            ]
        ],
        // Q9: Relationship Style
        [
            'id' => 9,
            'question' => 'Nos relacionamentos, você é:',
            'answers' => [
                [
                    'text' => 'Protetor e leal até o fim',
                    'scores' => ['community' => 80, 'faith' => 85, 'leadership' => 70, 'action' => 70, 'growth' => 60, 'innovation' => 30]
                ],
                [
                    'text' => 'Amigável mas mantém certa distância',
                    'scores' => ['community' => 50, 'faith' => 60, 'leadership' => 50, 'action' => 60, 'growth' => 65, 'innovation' => 70]
                ],
                [
                    'text' => 'Intenso, profundo e dedicado',
                    'scores' => ['community' => 85, 'faith' => 80, 'leadership' => 40, 'action' => 65, 'growth' => 75, 'innovation' => 40]
                ],
                [
                    'text' => 'Precisa de espaço e independência',
                    'scores' => ['community' => 30, 'faith' => 50, 'leadership' => 70, 'action' => 80, 'growth' => 70, 'innovation' => 80]
                ]
            ]
        ],
        // Q10: Decision Making
        [
            'id' => 10,
            'question' => 'Quando toma uma decisão importante:',
            'answers' => [
                [
                    'text' => 'Segue sua intuição',
                    'scores' => ['faith' => 90, 'action' => 80, 'growth' => 70, 'leadership' => 70, 'community' => 40, 'innovation' => 60]
                ],
                [
                    'text' => 'Consulta pessoas que confia',
                    'scores' => ['community' => 90, 'faith' => 60, 'action' => 50, 'leadership' => 40, 'growth' => 50, 'innovation' => 35]
                ],
                [
                    'text' => 'Pesa os prós e contras racionalmente',
                    'scores' => ['faith' => 20, 'action' => 60, 'growth' => 60, 'leadership' => 60, 'community' => 40, 'innovation' => 75]
                ],
                [
                    'text' => 'Decide rápido mas está aberto a ajustamentos',
                    'scores' => ['action' => 85, 'faith' => 50, 'growth' => 80, 'leadership' => 75, 'community' => 50, 'innovation' => 70]
                ]
            ]
        ],
        // Q11: Conflict Resolution
        [
            'id' => 11,
            'question' => 'Diante de conflito, você:',
            'answers' => [
                [
                    'text' => 'Enfrenta diretamente o problema',
                    'scores' => ['action' => 85, 'leadership' => 80, 'growth' => 75, 'faith' => 60, 'community' => 50, 'innovation' => 60]
                ],
                [
                    'text' => 'Busca reconciliação e harmonia',
                    'scores' => ['community' => 90, 'faith' => 80, 'action' => 40, 'leadership' => 40, 'growth' => 50, 'innovation' => 30]
                ],
                [
                    'text' => 'Analisa para achar a melhor solução',
                    'scores' => ['faith' => 30, 'action' => 50, 'growth' => 65, 'leadership' => 60, 'community' => 50, 'innovation' => 80]
                ],
                [
                    'text' => 'Deixa a situação resfriar antes de agir',
                    'scores' => ['faith' => 70, 'action' => 30, 'growth' => 45, 'leadership' => 40, 'community' => 60, 'innovation' => 40]
                ]
            ]
        ],
        // Q12: Career Aspiration
        [
            'id' => 12,
            'question' => 'Idealmente, seu papel seria:',
            'answers' => [
                [
                    'text' => 'Líder visionário que inspira mudança',
                    'scores' => ['leadership' => 95, 'innovation' => 85, 'growth' => 80, 'action' => 80, 'faith' => 70, 'community' => 60]
                ],
                [
                    'text' => 'Mentor ou professor guiando outros',
                    'scores' => ['community' => 85, 'growth' => 85, 'leadership' => 70, 'faith' => 80, 'action' => 60, 'innovation' => 50]
                ],
                [
                    'text' => 'Especialista técnico resolvendo problemas',
                    'scores' => ['faith' => 30, 'action' => 70, 'innovation' => 80, 'leadership' => 40, 'community' => 40, 'growth' => 70]
                ],
                [
                    'text' => 'Criador inovador trazendo ideias novas',
                    'scores' => ['innovation' => 95, 'growth' => 85, 'leadership' => 70, 'action' => 80, 'faith' => 50, 'community' => 40]
                ]
            ]
        ],
        // Q13: Spirituality/Purpose
        [
            'id' => 13,
            'question' => 'Sua relação com propósito de vida é:',
            'answers' => [
                [
                    'text' => 'Tenho uma missão clara e sigo fielmente',
                    'scores' => ['faith' => 95, 'action' => 85, 'leadership' => 80, 'growth' => 75, 'community' => 70, 'innovation' => 40]
                ],
                [
                    'text' => 'Estou descobrindo meu propósito',
                    'scores' => ['growth' => 90, 'innovation' => 80, 'action' => 70, 'leadership' => 60, 'faith' => 50, 'community' => 60]
                ],
                [
                    'text' => 'Meu propósito é servir e ajudar outros',
                    'scores' => ['community' => 95, 'faith' => 80, 'growth' => 75, 'leadership' => 60, 'action' => 70, 'innovation' => 40]
                ],
                [
                    'text' => 'Prefiro focar no presente e no concreto',
                    'scores' => ['action' => 80, 'faith' => 25, 'growth' => 50, 'leadership' => 60, 'community' => 40, 'innovation' => 70]
                ]
            ]
        ],
        // Q14: Learning Style
        [
            'id' => 14,
            'question' => 'Você aprende melhor:',
            'answers' => [
                [
                    'text' => 'Fazendo, experimentando na prática',
                    'scores' => ['action' => 90, 'growth' => 80, 'faith' => 50, 'leadership' => 70, 'community' => 50, 'innovation' => 75]
                ],
                [
                    'text' => 'Ouvindo histórias e exemplos de pessoas',
                    'scores' => ['community' => 85, 'faith' => 80, 'action' => 60, 'leadership' => 60, 'growth' => 70, 'innovation' => 40]
                ],
                [
                    'text' => 'Estudando profundamente a teoria',
                    'scores' => ['faith' => 40, 'action' => 40, 'growth' => 70, 'leadership' => 50, 'community' => 40, 'innovation' => 85]
                ],
                [
                    'text' => 'Observando e imitando mestres',
                    'scores' => ['community' => 70, 'faith' => 75, 'action' => 60, 'leadership' => 40, 'growth' => 60, 'innovation' => 30]
                ]
            ]
        ],
        // Q15: Adversity Response
        [
            'id' => 15,
            'question' => 'Quando enfrenta adversidade:',
            'answers' => [
                [
                    'text' => 'Fico mais forte e determinado',
                    'scores' => ['growth' => 85, 'action' => 85, 'faith' => 80, 'leadership' => 85, 'community' => 50, 'innovation' => 60]
                ],
                [
                    'text' => 'Busco apoio nos outros',
                    'scores' => ['community' => 90, 'faith' => 75, 'growth' => 60, 'leadership' => 40, 'action' => 50, 'innovation' => 30]
                ],
                [
                    'text' => 'Analiso o problema para encontrar saída',
                    'scores' => ['faith' => 30, 'action' => 70, 'growth' => 75, 'leadership' => 60, 'community' => 40, 'innovation' => 85]
                ],
                [
                    'text' => 'Questiono tudo e duvido',
                    'scores' => ['faith' => 15, 'action' => 50, 'growth' => 50, 'leadership' => 40, 'community' => 40, 'innovation' => 75]
                ]
            ]
        ],
        // Q16: Social Role
        [
            'id' => 16,
            'question' => 'Na sua comunidade, você é conhecido por:',
            'answers' => [
                [
                    'text' => 'Ser uma pessoa de ação e resultados',
                    'scores' => ['action' => 90, 'leadership' => 85, 'growth' => 80, 'faith' => 60, 'community' => 60, 'innovation' => 70]
                ],
                [
                    'text' => 'Ser o amigo leal que todos confiam',
                    'scores' => ['community' => 95, 'faith' => 85, 'action' => 50, 'leadership' => 40, 'growth' => 60, 'innovation' => 30]
                ],
                [
                    'text' => 'Ser o pensador que questiona coisas',
                    'scores' => ['faith' => 25, 'action' => 50, 'growth' => 70, 'leadership' => 50, 'community' => 40, 'innovation' => 90]
                ],
                [
                    'text' => 'Ser o criador e inovador',
                    'scores' => ['innovation' => 95, 'growth' => 85, 'action' => 80, 'leadership' => 70, 'community' => 40, 'faith' => 40]
                ]
            ]
        ],
        // Q17: Values
        [
            'id' => 17,
            'question' => 'O que você valoriza mais:',
            'answers' => [
                [
                    'text' => 'Lealdade e fidelidade',
                    'scores' => ['faith' => 90, 'community' => 85, 'growth' => 60, 'leadership' => 70, 'action' => 60, 'innovation' => 20]
                ],
                [
                    'text' => 'Autenticidade e honestidade',
                    'scores' => ['faith' => 80, 'action' => 75, 'growth' => 80, 'leadership' => 70, 'community' => 70, 'innovation' => 50]
                ],
                [
                    'text' => 'Liberdade e autonomia',
                    'scores' => ['innovation' => 85, 'action' => 80, 'growth' => 75, 'leadership' => 80, 'community' => 30, 'faith' => 40]
                ],
                [
                    'text' => 'Conhecimento e verdade',
                    'scores' => ['faith' => 30, 'action' => 60, 'growth' => 80, 'leadership' => 50, 'community' => 40, 'innovation' => 85]
                ]
            ]
        ],
        // Q18: Communication
        [
            'id' => 18,
            'question' => 'Sua forma de comunicação é:',
            'answers' => [
                [
                    'text' => 'Direta e clara, sem rodeios',
                    'scores' => ['action' => 85, 'faith' => 70, 'leadership' => 85, 'growth' => 70, 'community' => 50, 'innovation' => 70]
                ],
                [
                    'text' => 'Calorosa e conectada com as emoções',
                    'scores' => ['community' => 95, 'faith' => 85, 'action' => 60, 'leadership' => 50, 'growth' => 70, 'innovation' => 30]
                ],
                [
                    'text' => 'Cuidadosa e considero múltiplas perspectivas',
                    'scores' => ['faith' => 50, 'action' => 50, 'growth' => 70, 'leadership' => 50, 'community' => 80, 'innovation' => 60]
                ],
                [
                    'text' => 'Desafiadora e questiono ideias',
                    'scores' => ['faith' => 20, 'action' => 70, 'growth' => 75, 'leadership' => 70, 'community' => 40, 'innovation' => 85]
                ]
            ]
        ],
        // Q19: Ambition Level
        [
            'id' => 19,
            'question' => 'Sua ambição pessoal é:',
            'answers' => [
                [
                    'text' => 'Muito alta — quero fazer diferença em grande escala',
                    'scores' => ['leadership' => 95, 'growth' => 90, 'action' => 85, 'innovation' => 80, 'faith' => 70, 'community' => 60]
                ],
                [
                    'text' => 'Moderada — focar em objetivos pessoais realistas',
                    'scores' => ['growth' => 65, 'action' => 70, 'leadership' => 50, 'innovation' => 60, 'faith' => 70, 'community' => 70]
                ],
                [
                    'text' => 'Baixa — contentamento em meu círculo é suficiente',
                    'scores' => ['growth' => 35, 'action' => 40, 'leadership' => 30, 'innovation' => 30, 'faith' => 85, 'community' => 85]
                ],
                [
                    'text' => 'Específica — dominar uma área que me interessa',
                    'scores' => ['growth' => 80, 'action' => 75, 'leadership' => 60, 'innovation' => 85, 'faith' => 40, 'community' => 45]
                ]
            ]
        ],
        // Q20: Final — Self-Perception
        [
            'id' => 20,
            'question' => 'Me defino melhor como:',
            'answers' => [
                [
                    'text' => 'Um guerreiro — corajoso, determinado, combativo',
                    'scores' => ['action' => 95, 'leadership' => 90, 'growth' => 80, 'faith' => 70, 'community' => 40, 'innovation' => 50]
                ],
                [
                    'text' => 'Um amigo — leal, empático, amoroso',
                    'scores' => ['community' => 95, 'faith' => 90, 'action' => 50, 'leadership' => 40, 'growth' => 65, 'innovation' => 25]
                ],
                [
                    'text' => 'Um pensador — crítico, analítico, questionador',
                    'scores' => ['faith' => 20, 'action' => 60, 'growth' => 75, 'leadership' => 50, 'community' => 40, 'innovation' => 90]
                ],
                [
                    'text' => 'Um visionário — inovador, criativo, ousado',
                    'scores' => ['innovation' => 95, 'growth' => 85, 'action' => 80, 'leadership' => 80, 'faith' => 50, 'community' => 40]
                ]
            ]
        ]
    ];
}

/**
 * Get a single question by ID
 */
function getQuestionById($id) {
    $questions = getQuestions();
    foreach ($questions as $q) {
        if ($q['id'] == $id) {
            return $q;
        }
    }
    return null;
}

/**
 * Get all questions (for loading quiz)
 */
function getAllQuestions() {
    return getQuestions();
}

/**
 * Get total number of questions
 */
function getTotalQuestions() {
    return count(getQuestions());
}
