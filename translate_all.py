import json
import os
import time
from deep_translator import GoogleTranslator

locales = ['en', 'es', 'fr', 'de', 'zh', 'ar', 'hi', 'pt', 'ru', 'ja']

# GoogleTranslator language codes
lang_map = {
    'en': 'en',
    'es': 'es',
    'fr': 'fr',
    'de': 'de',
    'zh': 'zh-CN',  # Simplified Chinese
    'ar': 'ar',
    'hi': 'hi',
    'pt': 'pt',
    'ru': 'ru',
    'ja': 'ja'
}

with open('extracted_keys.json', 'r', encoding='utf-8') as f:
    keys = json.load(f)

print(f"Loaded {len(keys)} keys to translate.")

for loc in locales:
    if loc == 'en':
        filepath = "lang/en.json"
        data = {}
        if os.path.exists(filepath):
            with open(filepath, "r", encoding="utf-8") as f:
                data = json.load(f)
        
        # update English keys
        for key in keys:
            if key not in data:
                data[key] = key
                
        with open(filepath, "w", encoding="utf-8") as f:
            json.dump(data, f, ensure_ascii=False, indent=4)
        continue

    filepath = f"lang/{loc}.json"
    data = {}
    if os.path.exists(filepath):
        with open(filepath, "r", encoding="utf-8") as f:
            data = json.load(f)
            
    translator = GoogleTranslator(source='en', target=lang_map[loc])
    
    new_keys = [k for k in keys if k not in data]
    print(f"Translating {len(new_keys)} new keys for {loc}...")
    
    # Translate in chunks of 50 to avoid request URL too long
    chunk_size = 50
    for i in range(0, len(new_keys), chunk_size):
        chunk = new_keys[i:i+chunk_size]
        try:
            translations = translator.translate_batch(chunk)
            for j, k in enumerate(chunk):
                data[k] = translations[j]
        except Exception as e:
            print(f"Error translating chunk for {loc}: {e}")
            # fallback to individual translation
            for k in chunk:
                try:
                    data[k] = translator.translate(k)
                    time.sleep(0.5)
                except Exception as inner_e:
                    print(f"Failed to translate '{k}': {inner_e}")
                    data[k] = k # fallback to english

        # save progress
        with open(filepath, "w", encoding="utf-8") as f:
            json.dump(data, f, ensure_ascii=False, indent=4)
        print(f"  {min(i+chunk_size, len(new_keys))}/{len(new_keys)} complete.")
        time.sleep(1) # rate limiting pause

print("Translation generation complete.")
