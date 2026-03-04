import fs from 'fs';
import { translate } from '@vitalets/google-translate-api';

const locales = ['es', 'fr', 'de', 'zh-CN', 'ar', 'hi', 'pt', 'ru', 'ja'];
const langMap = {
    'es': 'es',
    'fr': 'fr',
    'de': 'de',
    'zh-CN': 'zh', // In our filenames it's zh.json
    'ar': 'ar',
    'hi': 'hi',
    'pt': 'pt',
    'ru': 'ru',
    'ja': 'ja'
};
const fileNameMap = {
    'es': 'es', 'fr': 'fr', 'de': 'de', 'zh-CN': 'zh', 'ar': 'ar', 'hi': 'hi', 'pt': 'pt', 'ru': 'ru', 'ja': 'ja'
};

const delay = ms => new Promise(res => setTimeout(res, ms));

async function main() {
    const keysRaw = fs.readFileSync('extracted_keys.json', 'utf8');
    const keys = JSON.parse(keysRaw);
    console.log(`Loaded ${keys.length} keys`);

    for (let code of locales) {
        console.log(`Processing ${code}...`);
        const jsonPath = `lang/${fileNameMap[code]}.json`;
        let data = {};
        if (fs.existsSync(jsonPath)) {
            data = JSON.parse(fs.readFileSync(jsonPath, 'utf8'));
        }

        const newKeys = keys.filter(k => !data[k]);
        console.log(` Translating ${newKeys.length} new keys for ${code}...`);

        let i = 0;
        for (let k of newKeys) {
            try {
                const res = await translate(k, { to: code });
                data[k] = res.text;
                if (++i % 10 === 0) console.log(`   ${i}/${newKeys.length}`);

                if (i % 5 === 0) {
                    fs.writeFileSync(jsonPath, JSON.stringify(data, null, 4));
                }
                await delay(100);
            } catch (err) {
                console.error(` Error on '${k}':`, err.message);
                if (err.name === 'TooManyRequestsError' || err.message.includes('TooManyRequests')) {
                    console.log('Rate limited. Waiting 5s...');
                    await delay(5000);
                    // attempt once more
                    try {
                        const res = await translate(k, { to: code });
                        data[k] = res.text;
                    } catch (e) { /* give up on this key */ }
                }
            }
        }
        fs.writeFileSync(jsonPath, JSON.stringify(data, null, 4));
        console.log(`Finished ${code}\n`);
    }

    // Process EN
    let enData = {};
    if (fs.existsSync('lang/en.json')) {
        enData = JSON.parse(fs.readFileSync('lang/en.json', 'utf8'));
    }
    keys.forEach(k => { if (!enData[k]) enData[k] = k; });
    fs.writeFileSync('lang/en.json', JSON.stringify(enData, null, 4));
    console.log("English completed");
}

main();
