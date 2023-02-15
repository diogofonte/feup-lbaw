import requests
from bs4 import BeautifulSoup
from tabulate import tabulate
import random

size_convertion = {
  "24": "XS",
  "25": "XS",
  "26": "XS",
  "27": "XS",
  "28": "XS",
  "29": "S",
  "30": "S",
  "31": "M",
  "32": "M",
  "33": "M",
  "34": "L",
  "35": "L",
  "36": "XL",
  "37": "XL",
  "38": "XL",
  "39": "XL",
  "40": "XXL",
  "41": "XXL",
  "42": "XXL",
  "43": "XXL"
}


def scrape(products, catg_id,  conversion=True):
    products_data = []
    products_struct = []
    for product in products:
        name = product.find("div", class_="c-product-tile__name").text.strip()
        price = product.find("div", class_="o-price__price").find("span", class_="o-price__sales").text.strip()
        images_links = product.find("div", class_="swiper-wrapper").find_all("img")
        images = [img["data-src"] for img in images_links]
        sizes_links = product.find("li", id="product-option-size").find_all("li", class_="c-variations__subitem c-variations__subitem--quck-shop js-product-variations__subitem selectable") 
        sizes = []
        for link in sizes_links:
            size_str = str(link.find("button").text)
            if (size_str.isnumeric() and conversion):
                size = size_convertion[size_str]
                if size in ["XS","S","M","L","XL"] and size not in sizes:
                    sizes.append(size)
            else:
                size = size_str
                sizes.append(size)

        colors_links = product.find("ul", class_="swatch-list js-swatch-list").find_all("li")
        colors = [color["data-color-value"] for color in colors_links]
        prc = str(price[:-1].replace(",","."))
        products_data.append([name, float(prc), len(images), ' '.join(sizes), ' '.join(colors)])
        products_struct.append({"name": name, "price": prc, "rating":random.randint(0, 5), "imgs": images, "sizes": sizes, "colors": colors, "catg": catg_id})
    return (products_data, products_struct)

# MAN CLOTHING
URL_H_CASACOS     = "https://www.pepejeans.com/pt_pt/homem/colecao/casaco-e-jaquetas?productViewMode=model&gridViewMode=sparse&start=0&sz=72"
URL_H_MALHAS      = "https://www.pepejeans.com/pt_pt/homem/colecao/malhas?productViewMode=model&gridViewMode=sparse&start=0&sz=99"
URL_H_SWEATS      = "https://www.pepejeans.com/pt_pt/homem/sweats-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=48"
URL_H_CAMISAS     = "https://www.pepejeans.com/pt_pt/homem/colecao/camisas?productViewMode=model&gridViewMode=sparse&start=0&sz=72"
URL_H_TSHIRTS     = "https://www.pepejeans.com/pt_pt/homem/colecao/t-shirts?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_POLOS       = "https://www.pepejeans.com/pt_pt/homem/colecao/polos?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_CALCAS      = "https://www.pepejeans.com/pt_pt/homem/colecao/calcas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_UNDERWEAR   = "https://www.pepejeans.com/pt_pt/homem/colecao/underwear?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_JEANS       = "https://www.pepejeans.com/pt_pt/homem/colecao/jeans?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

# MAN FOOTWEAR
URL_H_SAPATILHAS = "https://www.pepejeans.com/pt_pt/homem/sapatilhas-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_BOTAS = "https://www.pepejeans.com/pt_pt/homem/calcado/botas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

# MAN ACCESSORIES
URL_H_MOCHILAS = "https://www.pepejeans.com/pt_pt/homem/mochilas-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_CINTOS = "https://www.pepejeans.com/pt_pt/homem/cintos-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_GORROS = "https://www.pepejeans.com/pt_pt/homem/chapeus-gorros-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_CACHECOIS = "https://www.pepejeans.com/pt_pt/homem/cachecois-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_OCULOS = "https://www.pepejeans.com/pt_pt/homem/oculos-de-sol-homem?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_PERFUMES = "https://www.pepejeans.com/pt_pt/homem/perfume-homem-pepe-jeans?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_H_MALAS = "https://www.pepejeans.com/pt_pt/homem/acessorios/malas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

# WOMAN CLOTHING
URL_M_CASACOS   = "https://www.pepejeans.com/pt_pt/mulher/colecao/casacos-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_VESTIDOS  = "https://www.pepejeans.com/pt_pt/mulher/colecao/vestidos-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_MALHAS    = "https://www.pepejeans.com/pt_pt/mulher/malhas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_CAMISAS   = "https://www.pepejeans.com/pt_pt/mulher/camisas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_SWEATS    = "https://www.pepejeans.com/pt_pt/mulher/sweats-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_CALCAS    = "https://www.pepejeans.com/pt_pt/mulher/colecao/calcas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_TSHIRTS   = "https://www.pepejeans.com/pt_pt/mulher/colecao/t-shirts-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_SAIAS     = "https://www.pepejeans.com/pt_pt/mulher/colecao/saias-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_UNDERWEAR = "https://www.pepejeans.com/pt_pt/mulher/colecao/underwear?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

# WOMAN FOOTWEAR
URL_M_SAPATILHAS = "https://www.pepejeans.com/pt_pt/mulher/calcado/sapatilhas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_BOTAS = "https://www.pepejeans.com/pt_pt/mulher/botas-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

#WOMAN ACCESSORIES
URL_M_MOCHILAS = "https://www.pepejeans.com/pt_pt/mulher/women-bags?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_MALAS = "https://www.pepejeans.com/pt_pt/mulher/acessorios/malas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_CINTOS = "https://www.pepejeans.com/pt_pt/mulher/cintos-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_GORROS = "https://www.pepejeans.com/pt_pt/mulher/chapeus-gorros-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_CACHECOIS = "https://www.pepejeans.com/pt_pt/mulher/cachecois-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_OCULOS = "https://www.pepejeans.com/pt_pt/mulher/oculos-de-sol-mulher?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_PERFUMES = "https://www.pepejeans.com/pt_pt/mulher/perfume-mulher-pepe-jeans?productViewMode=model&gridViewMode=sparse&start=0&sz=200"
URL_M_MALAS = "https://www.pepejeans.com/pt_pt/mulher/acessorios/malas?productViewMode=model&gridViewMode=sparse&start=0&sz=200"

catg_id = {}
sizes_id = {}
colors_id = {}
imgs_id = {}

i = 9
for url in [URL_H_CASACOS, URL_H_MALHAS, URL_H_SWEATS, URL_H_POLOS, URL_H_TSHIRTS, URL_H_CAMISAS, URL_H_CALCAS, URL_H_UNDERWEAR,
            URL_H_SAPATILHAS, URL_H_BOTAS,
            URL_H_MOCHILAS, URL_H_CINTOS, URL_H_GORROS, URL_H_CACHECOIS, URL_H_OCULOS, URL_H_PERFUMES, URL_H_MALAS,
            URL_M_VESTIDOS, URL_M_CASACOS, URL_M_MALHAS, URL_M_CALCAS, URL_M_CAMISAS, URL_M_SWEATS, URL_M_TSHIRTS, URL_M_SAIAS, URL_M_UNDERWEAR,
            URL_M_SAPATILHAS, URL_M_BOTAS,
            URL_M_MOCHILAS, URL_M_CINTOS, URL_M_GORROS, URL_M_CACHECOIS, URL_M_OCULOS, URL_M_PERFUMES, URL_M_MALAS]:
            catg_id[url] = i
            i += 1

#for k in catgs:
    #print("%s  %s" %(catgs[k], k))

sql_inserts = []
prod_id = 1; size_id = 1; color_id = 1; img_id = 1
all_products_struct = []

for URL in  [URL_H_CASACOS, URL_H_MALHAS, URL_H_SWEATS, URL_H_POLOS, URL_H_TSHIRTS, URL_H_CAMISAS, URL_H_CALCAS, URL_H_UNDERWEAR,
            URL_H_SAPATILHAS, URL_H_BOTAS,
            URL_H_MOCHILAS, URL_H_CINTOS, URL_H_GORROS, URL_H_CACHECOIS, URL_H_OCULOS, URL_H_PERFUMES, URL_H_MALAS,
            URL_M_VESTIDOS, URL_M_CASACOS, URL_M_MALHAS, URL_M_CALCAS, URL_M_CAMISAS, URL_M_SWEATS, URL_M_TSHIRTS, URL_M_SAIAS, URL_M_UNDERWEAR,
            URL_M_SAPATILHAS, URL_M_BOTAS,
            URL_M_MOCHILAS, URL_M_CINTOS, URL_M_GORROS, URL_M_CACHECOIS, URL_M_OCULOS, URL_M_PERFUMES, URL_M_MALAS]:

    page = requests.get(URL)
    page_bs = BeautifulSoup(page.content, "html.parser")
    products = page_bs.find_all("div", class_="product-tile")
    if (URL in [URL_H_SAPATILHAS, URL_H_BOTAS,
                URL_H_MOCHILAS, URL_H_CINTOS, URL_H_GORROS, URL_H_CACHECOIS, URL_H_OCULOS, URL_H_PERFUMES, URL_H_MALAS,
                URL_M_SAPATILHAS, URL_M_BOTAS,
                URL_M_MOCHILAS, URL_M_CINTOS, URL_M_GORROS, URL_M_CACHECOIS, URL_M_OCULOS, URL_M_PERFUMES, URL_M_MALAS]):
        products_data = scrape(products, catg_id[URL], False)[0]
        products_struct = scrape(products, catg_id[URL], False)[1]
    else:
        products_data = scrape(products, catg_id[URL])[0]
        products_struct = scrape(products, catg_id[URL])[1]
    all_products_struct += products_struct
    f = URL.find('?')
    print("\n\n%s: %d" %(URL[38:f], len(products)))
    print(tabulate(products_data, headers=["Name", "Price", "Num_Imgs", "Sizes", "Colors"]))


# remove duplicate product with same name
seen = set()
new_products_struct = []
for d in all_products_struct:
    t = d["name"]
    if t not in seen:
        seen.add(t)
        new_products_struct.append(d)
all_products_struct = new_products_struct


# build insert values into tables
for prod in all_products_struct:
    for size in prod["sizes"]:
        if size not in sizes_id:
            sizes_id[size]=size_id
            sql_inserts.append("insert into size (id, name) values (DEFAULT, '%s');" %(size))
            size_id+=1

for prod in all_products_struct:
    for color in prod["colors"]:
        if color not in colors_id:
            colors_id[color]=color_id
            sql_inserts.append("insert into color (id, name) values (DEFAULT, '%s');" %(color))
            color_id+=1

for prod in all_products_struct:
    for img in prod["imgs"]:
        if img not in imgs_id:
            imgs_id[img]=img_id
            sql_inserts.append("insert into image (id, file) values (DEFAULT, '%s');" %(img))
            img_id+=1

for prod in all_products_struct:
    sql_inserts.append("insert into product (id, name, description, price, avg_classification, id_category) values (DEFAULT, '%s', '%s', %s, %i, %i);" %(prod["name"], "None", prod["price"], prod["rating"], prod["catg"]))
    #for img in prod["imgs"]:
    #    sql_inserts.append("insert into product_image (id_product, id_image) values (%i, %i);" %(prod_id, imgs_id[img]))
    #for color in prod["colors"]:
    #    for size in prod["sizes"]:
    #        sql_inserts.append("insert into stock (stock, id_product, id_size, id_color) values (%i, %i, %i, %i);" %(random.randrange(300), prod_id, sizes_id[size], colors_id[color]))   
    prod_id+=1
#sql_inserts.append("\n")
#break

f = open("inserts.txt", "w")
for line in sql_inserts:
    f.write(line)
    f.write("\n")
    #print(line)
f.close()

print("\nprodutos: %i " %(prod_id))
print("images: %i " %(img_id))
print("colors: %i " %(color_id))
print("sizes: %i " %(size_id))
