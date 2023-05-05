const fetchEvaluationQuestions = async ({ params }) => {
    const quiz = [
        null,
        [
            {
                title: 'Quel est le meilleur jeu au monde ?',
                qcm: true,
                choix1: 'Destiny 2',
                choix2: 'Monster Hunter World',
                choix3: 'Dark Souls 3',
                choix4: 'Tennis',
                reponse: null,
                repChoix1: false,
                repChoix2: false,
                repChoix3: false,
                repChoix4: false,
            }, {
                title: 'As-tu menti à la première question ?',
                qcm: true,
                choix1: 'Oui',
                choix2: 'Oui',
                reponse: null,
                repChoix1: false,
                repChoix2: false,
            }, {
                title: 'Si tu penses avoir raison, rédige une lettre de 2000 caractères.',
                qcm: false,
                reponse: '',
            }
        ],
        [
            {
                title: 'test',
                qmc: false,
                reponse: '',
            }
        ]
    ]

    if (!quiz[params.evaluationId]) throw new Response('No quiz', { status: 404 });

    const res = {};
    res.questions = quiz[params.evaluationId];
    res.lastQuestion = 0; // TODO: Garder en mémoire la dernière question à laquelle a répondu l'élève

    return res.questions;
}

export default fetchEvaluationQuestions;
