const mockJobs = [
    {
        id: 1,
        job_title_ar: "مهندس برمجيات سينيور",
        company_name: "تقنيات اليمن المتقدمة",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 2000000,
        salary_max: 3500000,
        job_description_ar: "نحن نبحث عن مهندس برمجيات ذو خبرة عالية في تطوير تطبيقات الويب والموبايل باستخدام أحدث التقنيات. يجب أن يكون لديك خبرة لا تقل عن 5 سنوات في مجال البرمجة.",
        published_at: "2024-11-20"
    },
    {
        id: 2,
        job_title_ar: "مصمم جرافيكس احترافي",
        company_name: "ستوديو الإبداع الرقمي",
        job_type: "full_time",
        location_city: "عدن",
        salary_min: 1500000,
        salary_max: 2500000,
        job_description_ar: "نبحث عن مصمم جرافيكس مبدع لإنشاء محتوى بصري متميز. الخبرة في Adobe Creative Suite وفيجما مهمة جداً.",
        published_at: "2024-11-19"
    },
    {
        id: 3,
        job_title_ar: "متخصص تسويق رقمي",
        company_name: "وكالة التسويق الذكي",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 1800000,
        salary_max: 2800000,
        job_description_ar: "فرصة رائعة للعمل في مجال التسويق الرقمي والإعلانات على وسائل التواصل. نبحث عن شخص لديه خبرة في SEO والإعلانات المدفوعة.",
        published_at: "2024-11-21"
    },
    {
        id: 4,
        job_title_ar: "مدير المشاريع",
        company_name: "شركة الحلول المتكاملة",
        job_type: "full_time",
        location_city: "تعز",
        salary_min: 2200000,
        salary_max: 3200000,
        job_description_ar: "نبحث عن مدير مشاريع متمرس لإدارة مشاريع تقنية معقدة. يجب أن تكون لديك شهادة PMP أو ما يعادلها.",
        published_at: "2024-11-18"
    },
    {
        id: 5,
        job_title_ar: "محلل بيانات",
        company_name: "منصة البيانات الكبرى",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 1900000,
        salary_max: 2900000,
        job_description_ar: "متخصص في تحليل البيانات وإنشاء التقارير. الخبرة مع SQL و Python و Tableau ضرورية. تحليل كميات ضخمة من البيانات يومياً.",
        published_at: "2024-11-20"
    },
    {
        id: 6,
        job_title_ar: "مطور فرونت إند",
        company_name: "ستارتب التقنية الرائدة",
        job_type: "full_time",
        location_city: "عدن",
        salary_min: 1700000,
        salary_max: 2600000,
        job_description_ar: "نابحث عن مطور فرونت إند بكفاءة عالية. الخبرة مع React أو Vue.js والتعامل مع APIs و REST ضرورية.",
        published_at: "2024-11-21"
    },
    {
        id: 7,
        job_title_ar: "أخصائي أمان المعلومات",
        company_name: "شركة الحماية السيبرانية",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 2500000,
        salary_max: 3800000,
        job_description_ar: "متخصص في أمان المعلومات والحماية السيبرانية. الخبرة في penetration testing والتشفير ضرورية جداً.",
        published_at: "2024-11-19"
    },
    {
        id: 8,
        job_title_ar: "مدير العلاقات العامة",
        company_name: "وكالة الاتصالات المميزة",
        job_type: "full_time",
        location_city: "إب",
        salary_min: 1600000,
        salary_max: 2400000,
        job_description_ar: "نبحث عن مدير علاقات عامة ذو خبرة في بناء العلاقات مع وسائل الإعلام والجمهور.",
        published_at: "2024-11-20"
    },
    {
        id: 9,
        job_title_ar: "مطور باك إند",
        company_name: "منصة التجارة الإلكترونية",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 1900000,
        salary_max: 2900000,
        job_description_ar: "مطور باك إند بكفاءة عالية. الخبرة مع Node.js أو Python و databases مثل MongoDB و PostgreSQL ضرورية.",
        published_at: "2024-11-21"
    },
    {
        id: 10,
        job_title_ar: "متخصص خدمة العملاء",
        company_name: "مركز الدعم العالمي",
        job_type: "part_time",
        location_city: "عدن",
        salary_min: 900000,
        salary_max: 1400000,
        job_description_ar: "مندوب خدمة عملاء للتعامل مع استفسارات العملاء بشكل احترافي وسريع. العمل بدوام جزئي مع مرونة في الساعات.",
        published_at: "2024-11-18"
    },
    {
        id: 11,
        job_title_ar: "مهندس تطوير DevOps",
        company_name: "شركة البنية التحتية",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 2300000,
        salary_max: 3400000,
        job_description_ar: "مهندس DevOps متمرس للعمل على أتمتة العمليات والبنية التحتية. الخبرة مع Docker و Kubernetes و CI/CD مهمة.",
        published_at: "2024-11-20"
    },
    {
        id: 12,
        job_title_ar: "مترجم اللغة الإنجليزية",
        company_name: "مكتب الترجمة المتقدم",
        job_type: "freelance",
        location_city: "تعز",
        salary_min: 0,
        salary_max: 0,
        job_description_ar: "مترجم محترف للعمل على ترجمة نصوص تقنية وتجارية من الإنجليزية للعربية والعكس. العمل بنظام العمل الحر.",
        published_at: "2024-11-19"
    },
    {
        id: 13,
        job_title_ar: "محاسب مالي",
        company_name: "شركة الاستشارات المالية",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 1700000,
        salary_max: 2500000,
        job_description_ar: "محاسب متمرس للعمل على المحاسبة المالية والتقارير المالية. الخبرة مع البرامج المحاسبية ضرورية.",
        published_at: "2024-11-21"
    },
    {
        id: 14,
        job_title_ar: "مدير موارد بشرية",
        company_name: "شركة الموارد البشرية المتقدمة",
        job_type: "full_time",
        location_city: "عدن",
        salary_min: 2000000,
        salary_max: 3000000,
        job_description_ar: "مدير موارد بشرية بخبرة لا تقل عن 8 سنوات. التعامل مع التوظيف والتطوير والعلاقات الموظفين.",
        published_at: "2024-11-20"
    },
    {
        id: 15,
        job_title_ar: "مصور فوتوغرافي احترافي",
        company_name: "استوديو الصور الفنية",
        job_type: "freelance",
        location_city: "صنعاء",
        salary_min: 0,
        salary_max: 0,
        job_description_ar: "مصور فوتوغرافي محترف للعمل على مشاريع متنوعة. الخبرة في التصوير التجاري والحدث مهمة.",
        published_at: "2024-11-18"
    },
    {
        id: 16,
        job_title_ar: "مختص كتابة محتوى",
        company_name: "منصة الكتابة الرقمية",
        job_type: "part_time",
        location_city: "صنعاء",
        salary_min: 800000,
        salary_max: 1500000,
        job_description_ar: "كاتب محتوى متخصص في الكتابة الجذابة والمقنعة. خبرة في كتابة المدونات والمقالات والنصوص الترويجية.",
        published_at: "2024-11-21"
    },
    {
        id: 17,
        job_title_ar: "مهندس اختبار الجودة",
        company_name: "شركة جودة البرمجيات",
        job_type: "full_time",
        location_city: "تعز",
        salary_min: 1600000,
        salary_max: 2400000,
        job_description_ar: "مهندس اختبار جودة بخبرة في التقنيات الحديثة. الخبرة مع Selenium و TestNG ضرورية.",
        published_at: "2024-11-19"
    },
    {
        id: 18,
        job_title_ar: "مستشار أعمال استراتيجي",
        company_name: "شركة الاستشارات الإدارية",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 2400000,
        salary_max: 3600000,
        job_description_ar: "مستشار أعمال متمرس لتطوير الاستراتيجيات والحلول الإدارية. خبرة واسعة في عالم الأعمال.",
        published_at: "2024-11-20"
    },
    {
        id: 19,
        job_title_ar: "مدرب تطوير مهارات",
        company_name: "مركز التدريب والتطوير",
        job_type: "contract",
        location_city: "عدن",
        salary_min: 1400000,
        salary_max: 2200000,
        job_description_ar: "مدرب متخصص في تطوير المهارات الوظيفية والقيادية. خبرة في التدريب والتطوير المهني.",
        published_at: "2024-11-18"
    },
    {
        id: 20,
        job_title_ar: "متخصص تحسين محركات البحث SEO",
        company_name: "وكالة التسويق الرقمي",
        job_type: "full_time",
        location_city: "صنعاء",
        salary_min: 1700000,
        salary_max: 2600000,
        job_description_ar: "متخصص SEO محترف لتحسين ترتيب المواقع في محركات البحث. خبرة في الكلمات المفتاحية والـ backlinking.",
        published_at: "2024-11-21"
    }
];

function getMockJobs(filters = {}, page = 1, pageSize = 20) {
    let filtered = mockJobs;

    if (filters.search) {
        const searchTerm = filters.search.toLowerCase();
        filtered = filtered.filter(job =>
            job.job_title_ar.toLowerCase().includes(searchTerm) ||
            job.company_name.toLowerCase().includes(searchTerm) ||
            job.job_description_ar.toLowerCase().includes(searchTerm)
        );
    }

    if (filters.location) {
        filtered = filtered.filter(job => job.location_city === filters.location);
    }

    if (filters.job_type) {
        filtered = filtered.filter(job => job.job_type === filters.job_type);
    }

    const startIndex = (page - 1) * pageSize;
    const paginatedJobs = filtered.slice(startIndex, startIndex + pageSize);

    return {
        status: 'success',
        data: paginatedJobs,
        total: filtered.length
    };
}
