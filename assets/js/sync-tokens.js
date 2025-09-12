// sync-tokens-v4.js

const fs = require('fs-extra');

async function syncThemeJsonFromCss() {
  try {
    const inputCssPath = './assets/css/input.css'; // 👈 Verifique se este é o caminho certo
    const themeJsonPath = './theme.json';

    // 1. Lê o conteúdo do seu input.css
    const cssContent = await fs.readFile(inputCssPath, 'utf8');

    // 2. Extrai as variáveis de cor usando uma expressão regular
    const colorRegex = /--color-([\w-]+):\s*(#[0-9a-fA-F]{3,6});/g;
    let match;
    const colors = [];
    while ((match = colorRegex.exec(cssContent)) !== null) {
      const slug = match[1]; // Ex: 'logo-header'
      const colorValue = match[2]; // Ex: '#b401fc'
      const name = slug.charAt(0).toUpperCase() + slug.slice(1).replace(/-/g, ' ');
      
      colors.push({ slug, color: colorValue, name });
    }

    if (colors.length === 0) {
      console.log('⚠️ Nenhuma cor encontrada no CSS para sincronizar.');
      return;
    }

    // 3. Lê o theme.json existente
    const themeJson = await fs.readJson(themeJsonPath);

    // 4. Garante que a estrutura exista
    if (!themeJson.settings) themeJson.settings = {};
    if (!themeJson.settings.color) themeJson.settings.color = {};

    // 5. Atualiza a paleta de cores no theme.json
    themeJson.settings.color.palette = colors;

    // 6. Escreve o arquivo atualizado
    await fs.writeJson(themeJsonPath, themeJson, { spaces: 2 });
    
    console.log(`✅ theme.json sincronizado com ${colors.length} cores do seu CSS!`);

  } catch (error) {
    console.error('❌ Erro ao sincronizar o theme.json a partir do CSS:', error);
  }
}

syncThemeJsonFromCss();