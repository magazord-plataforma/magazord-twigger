    # MagaZord Twigger

### Introdução

O MagaZord Twigger é uma ferramenta para validação de modelos twig.

### Executando

O aplicativo pode ser executado diretamente a partir de sua imagem púbica

```bash
docker run --rm --name twigger -v /myapp:/home/twigger/app  magazord/twigger /myapp/template.html.twig
```

#### Extensões

Caso seu aplicativo utilize extensões customizadas do twig é provável que ocorram alerta de símbolos não encontrados
no momento da validação da sintaxe de seus templates.

De modo a tratar essa situação, o twigger considera uma estratégia de mocks simples, onde você pode fornecer arquivos
de texto para o runtime, onde nesses você relaciona o nome das suas funções e/ou filtros.

As suas funções devem ser relacionadas em um arquivo de nome **twig_functions.txt**

```text
app_menu_itens
app_menu
app_menu_blog
```

As suas funções devem ser relacionadas em um arquivo de nome **twig_filters.txt**

```text
app_image_cdn
app_link_tel
app_link_whatsapp
app_valor
```

Internamente o twigger procura esses arquivos no diretório **/addons** que pode ser montado como volume no momento da 
execução do aplicativo.

##### Executando

Para executar o aplicativo considerando extensões, a forma recomendada é a seguinte  

 ```
 docker run --rm \
  --name twigger \
  -v /myapp/.config:/addons \
  -v /myapp:/template  \
  magazord/twigger /template
 ```

Considerando que o caminho `/myapp/.config` corresponda a um diretório que contenha os arquivos de texto com a relação
de suas funções e filtros específicos.

### Contribuições

Contribuições, correções e sugestões de melhoria são muito bem-vindas.

Copyright (c) 2020-2022 MagaZord.