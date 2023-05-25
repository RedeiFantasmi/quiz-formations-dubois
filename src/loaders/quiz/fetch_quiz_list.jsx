const fetchQuizList = async () => {
    const quiz = [
        {
            id: 1,
            title: 'test quiz',
            createdAt: '2023-05-05 19:31',
            img: '/placeholder.png',
        },
        {
            id: 2,
            title: 'test quiz',
            createdAt: '2023-05-05 20:31',
            img: '/test.jpg',
        },
        {
            id: 3,
            title: 'test quiz',
            startDate: '2023-05-02 11:02',
            endDate: '2023-05-02 18:25',
            time: '4h',
            createdBy: 'Matt yeu',
        },
        {
            id: 4,
            title: 'test quiz',
            startDate: '2026-04-26 14:25',
            endDate: '2026-04-26 14:40',
            time: '15min',
            createdBy: 'Ching',
            img: '/test.jpg',
        },
        {
            id: 5,
            title: 'test quiz',
            startDate: '2026-04-26 14:25',
            endDate: '2026-04-26 14:40',
            time: '15min',
            createdBy: 'Jona Tend (vers la perfection)',
            img: '/placeholder.png',
        },
        {
            id: 6,
            title: 'test quiz',
            startDate: '2026-04-26 14:25',
            endDate: '2026-04-26 14:40',
            time: '15min',
            createdBy: 'Jona Tends (vers la perfection)',
            img: '/test.jpg',
        },
        {
            id: 7,
            title: 'test quiz',
            startDate: '2026-04-26 14:25',
            endDate: '2026-04-26 14:40',
            time: '15min',
            createdBy: 'Auguste Un',
            img: '/placeholder.png',
        },
    ];

    return quiz;
}

export default fetchQuizList;