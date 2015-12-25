/* 
 * File:   main.cpp
 * Author: WIFI
 *
 * Created on 21 de octubre de 2015, 9:31
 */

#include <stdio.h>
#include <ctime>
#include <stdlib.h>

struct conn {
    char conn_name;
    int user_1;
    int user_2;
};

struct nodo {
    conn list;
    nodo *next;
};
int aleatorio(int min, int max);
conn getElement();
nodo adjuntarInicio(nodo **lst, conn value);
void printLista(nodo *l);
void subprint(nodo *l);
int aleatorio(int min, int max);

int main() {
    srand(time(0));
    nodo *Lista;
    int n = aleatorio(1, 5);
    Lista = NULL;
    for (int i = 0; i < n; i++)
        adjuntarInicio(&Lista, getElement());
    printLista(Lista);

    printf("Hola");
    //scanf("%f", &f);
    return 0;
}

conn getElement() {
    conn myElem;
    char *grupo[] = {"C", "Q"};
    myElem.conn_name = *grupo[aleatorio(0, 1)];
    myElem.user_1 = aleatorio(1, 5);
    myElem.user_2 = aleatorio(1, 5);
    return myElem;
}

nodo adjuntarInicio(nodo **lst, conn value) {
    nodo *eleNuevo;
    eleNuevo = new nodo;
    eleNuevo->list = value;
    eleNuevo->next = *lst;
    *lst = eleNuevo;
}

void printLista(nodo *l) {
    nodo *lista;
    lista = l;
    int i = 0;
    while (lista != NULL) {
        printf("%d", i + 1, ")");
        subprint(lista);
        lista = lista->next;
        i++;
    }
}

void subprint(nodo *l) {
    nodo *lista;
    lista = l;
    printf("%s-> %d <-> %d \n", lista->list.conn_name, lista->list.user_1, lista->list.user_2);
}

int aleatorio(int min, int max) {
    return rand() % (max - min) + min;
}
