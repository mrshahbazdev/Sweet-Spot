import json
import os

locales = ['en', 'es', 'fr', 'de', 'zh', 'ar', 'hi', 'pt', 'ru', 'ja']
translations = {
    "Total Customers": {"es": "Total de clientes", "fr": "Total des clients", "de": "Kunden gesamt", "zh": "总客户", "ar": "إجمالي العملاء", "hi": "कुल ग्राहक", "pt": "Total de Clientes", "ru": "Всего клиентов", "ja": "総顧客数"},
    "Average Score": {"es": "Puntuación media", "fr": "Score moyen", "de": "Durchschnitt", "zh": "平均分", "ar": "متوسط النتيجة", "hi": "औसत स्कोर", "pt": "Pontuação Média", "ru": "Средний балл", "ja": "平均スコア"},
    "Top Customers %": {"es": "% Mejores clientes", "fr": "% Meilleurs clients", "de": "Top Kunden %", "zh": "顶级客户 %", "ar": "% أفضل العملاء", "hi": "शीर्ष ग्राहक %", "pt": "% Principais", "ru": "% Лучших", "ja": "トップ顧客 %"},
    "Total Revenue": {"es": "Ingresos totales", "fr": "Revenu total", "de": "Gesamtumsatz", "zh": "总收入", "ar": "إجمالي الإيرادات", "hi": "कुल आय", "pt": "Receita Total", "ru": "Общий доход", "ja": "総収益"},
    "Profitability vs Effort": {"es": "Rentabilidad vs Esfuerzo", "fr": "Rentabilité vs Effort", "de": "Rentabilität vs. Aufwand", "zh": "盈利 vs 努力", "ar": "الربحية مقابل الجهد", "hi": "लाभप्रदता बनाम प्रयास", "pt": "Rentabilidade vs Esforço", "ru": "Прибыльность vs Усилия", "ja": "収益性 vs 労力"},
    "Top 10 Customers": {"es": "Los 10 mejores clientes", "fr": "Top 10 des clients", "de": "Top 10 Kunden", "zh": "前10名客户", "ar": "أفضل 10 عملاء", "hi": "शीर्ष 10 ग्राहक", "pt": "Top 10 Clientes", "ru": "Топ-10 клиентов", "ja": "トップ10顧客"},
    "Raw Customer Data": {"es": "Datos brutos", "fr": "Données brutes", "de": "Rohdaten", "zh": "原始数据", "ar": "البيانات الخام", "hi": "कच्चा डेटा", "pt": "Dados Brutos", "ru": "Сырые данные", "ja": "生データ"},
    "Search customers...": {"es": "Buscar clientes...", "fr": "Rechercher...", "de": "Kunden suchen...", "zh": "搜索客户...", "ar": "ابحث عن عملاء...", "hi": "ग्राहक खोजें...", "pt": "Buscar clientes...", "ru": "Поиск клиентов...", "ja": "顧客を検索..."},
    "Add Customer": {"es": "Añadir cliente", "fr": "Ajouter client", "de": "Kunde hinzufügen", "zh": "添加客户", "ar": "إضافة عميل", "hi": "ग्राहक जोड़ें", "pt": "Incluir Cliente", "ru": "Добавить клиента", "ja": "顧客を追加"},
    "Rank": {"es": "Rango", "fr": "Rang", "de": "Rang", "zh": "排名", "ar": "مرتبة", "hi": "रैंक", "pt": "Posição", "ru": "Ранг", "ja": "ランク"},
    "Customer Name": {"es": "Nombre", "fr": "Nom", "de": "Name", "zh": "客户名称", "ar": "اسم العميل", "hi": "ग्राहक का नाम", "pt": "Nome", "ru": "Имя клиента", "ja": "顧客名"},
    "Industry": {"es": "Industria", "fr": "Secteur", "de": "Branche", "zh": "行业", "ar": "صناعة", "hi": "उद्योग", "pt": "Indústria", "ru": "Отрасль", "ja": "業界"},
    "Score": {"es": "Puntuación", "fr": "Score", "de": "Ergebnis", "zh": "分数", "ar": "نتيجة", "hi": "स्कोर", "pt": "Pontuação", "ru": "Балл", "ja": "スコア"},
    "Status": {"es": "Estado", "fr": "Statut", "de": "Status", "zh": "状态", "ar": "حالة", "hi": "स्थिति", "pt": "Status", "ru": "Статус", "ja": "ステータス"},
    "Actions": {"es": "Acciones", "fr": "Actions", "de": "Aktionen", "zh": "操作", "ar": "أفعال", "hi": "कार्रवाई", "pt": "Ações", "ru": "Действия", "ja": "アクション"},
    "Adjust Scoring Engine Weights": {"es": "Ajustar pesos de puntuación", "fr": "Ajuster les poids", "de": "Gewichte anpassen", "zh": "调整评分权重", "ar": "تعديل أوزان التقييم", "hi": "स्कोरिंग वज़न", "pt": "Ajustar Pesos", "ru": "Настройка весов", "ja": "重みを調整"},
    "Save Weights": {"es": "Guardar pesos", "fr": "Enregistrer les poids", "de": "Gewichte speichern", "zh": "保存权重", "ar": "حفظ الأوزان", "hi": "वज़न सहेजें", "pt": "Salvar Pesos", "ru": "Сохранить веса", "ja": "重みを保存"},
    "Recalculate Now ↗": {"es": "Recalcular ahora ↗", "fr": "Recalculer maintenant ↗", "de": "Neu berechnen ↗", "zh": "重新计算 ↗", "ar": "إعادة الحساب ↗", "hi": "पुनर्गणना करें ↗", "pt": "Recalcular Agora ↗", "ru": "Пересчитать ↗", "ja": "再計算 ↗"}
}

for loc in locales:
    filepath = f"lang/{loc}.json"
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            data = json.load(f)
    else:
        data = {}
    
    for en_key, trans in translations.items():
        if loc == 'en':
            data[en_key] = en_key
        else:
            data[en_key] = trans.get(loc, en_key)
            
    with open(filepath, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=4)
