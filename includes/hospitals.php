<?php
/**
 * hospitals.php — LifeStream Blood Donation App
 * Verified Hospital Dataset (May 2026)
 */

function get_all_hospitals(): array {
    return [
        ['id' => 1, 'name_ar' => 'مستشفى أسوان الجامعي', 'name_en' => 'Aswan University Hospitals', 'city' => 'أسوان', 'lat' => 24.0866039, 'lng' => 32.9078433, 'address_ar' => 'قصر الحاجر، أسوان'],
        ['id' => 2, 'name_ar' => 'مستشفى الصداقة', 'name_en' => 'Al-Sadaqa Hospital', 'city' => 'أسوان', 'lat' => 24.1031913, 'lng' => 32.9250226, 'address_ar' => 'الصداقة الجديدة، أسوان 2'],
        ['id' => 3, 'name_ar' => 'مستشفى أسوان التخصصي', 'name_en' => 'Aswan Specialized Hospital', 'city' => 'أسوان', 'lat' => 24.1034257, 'lng' => 32.9253676, 'address_ar' => 'أسوان 2'],
        ['id' => 4, 'name_ar' => 'مستشفى قلب أسوان - مؤسسة مجدي يعقوب', 'name_en' => 'Aswan Heart Centre – Magdi Yacoub Foundation', 'city' => 'أسوان', 'lat' => 24.0858133, 'lng' => 32.9081367, 'address_ar' => 'أسوان 1'],
        ['id' => 5, 'name_ar' => 'مستشفى الهلال الأحمر أسوان', 'name_en' => 'Red Crescent Hospital – Aswan', 'city' => 'أسوان', 'lat' => 24.0867852, 'lng' => 32.8986347, 'address_ar' => 'الشياخة الثالثة، أسوان 1'],
        ['id' => 6, 'name_ar' => 'مستشفى الإرسالية الإنجيلية (الجرمانية)', 'name_en' => 'Evangelical Mission Hospital (Al-Germaniyya)', 'city' => 'أسوان', 'lat' => 24.0855436, 'lng' => 32.8926636, 'address_ar' => 'كورنيش النيل، الشياخة الأولى، أسوان'],
        ['id' => 7, 'name_ar' => 'مستشفى النيل التخصصي', 'name_en' => 'Nile Specialized Hospital', 'city' => 'أسوان', 'lat' => 24.0849593, 'lng' => 32.8946509, 'address_ar' => 'الشياخة الثالثة، أسوان'],
        ['id' => 8, 'name_ar' => 'مستشفى المسلة التخصصي', 'name_en' => 'El-Masala Specialized Hospital', 'city' => 'أسوان', 'lat' => 24.0761296, 'lng' => 32.8931353, 'address_ar' => 'شارع الدكتور عبد الراضي حنفي، الشياخة الأولى، أسوان'],
        ['id' => 9, 'name_ar' => 'مستشفى أسوان العسكري', 'name_en' => 'Aswan Military Hospital', 'city' => 'أسوان', 'lat' => 24.0749648, 'lng' => 32.8884851, 'address_ar' => 'شارع السادات، الشياخة الأولى، أسوان'],
        ['id' => 10, 'name_ar' => 'مستشفى AMC أسوان', 'name_en' => 'AMC Aswan Medical Centre', 'city' => 'أسوان', 'lat' => 24.0722623, 'lng' => 32.8827814, 'address_ar' => 'شارع الفنادق، الشياخة الأولى، أسوان 1'],
        ['id' => 11, 'name_ar' => 'مستشفى حورس العام (إدفو)', 'name_en' => 'Horus General Hospital – Edfu', 'city' => 'إدفو', 'lat' => 24.9805610, 'lng' => 32.8813291, 'address_ar' => 'شارع خلف المستشفى، العام، إدفو'],
        ['id' => 12, 'name_ar' => 'مستشفى الملكة (إدفو)', 'name_en' => 'Al-Malaka Hospital – Edfu', 'city' => 'إدفو', 'lat' => 24.9692344, 'lng' => 32.8741074, 'address_ar' => 'أدفو، إدفو، أسوان'],
        ['id' => 13, 'name_ar' => 'مستشفى الكاشف التخصصي (إدفو)', 'name_en' => 'Al-Kashef Specialized Hospital – Edfu', 'city' => 'إدفو', 'lat' => 24.9878401, 'lng' => 32.8906742, 'address_ar' => 'الرديسية بحري، مركز إدفو، أسوان'],
        ['id' => 14, 'name_ar' => 'مستشفى كوم أمبو العام', 'name_en' => 'Kom Ombo General Hospital', 'city' => 'كوم أمبو', 'lat' => 24.4848380, 'lng' => 32.9487556, 'address_ar' => 'طريق القاهرة أسوان الصحراوي الشرقي، نمرة 7 بحري، كوم أمبو'],
        ['id' => 15, 'name_ar' => 'مستشفى دراو المركزي', 'name_en' => 'Daraw Central Hospital', 'city' => 'دراو', 'lat' => 24.4108126, 'lng' => 32.9297118, 'address_ar' => 'العباسية، دراو، أسوان'],
    ];
}

function get_hospital_by_id(int $id): ?array {
    foreach (get_all_hospitals() as $h) {
        if ($h['id'] === $id) return $h;
    }
    return null;
}
?>
