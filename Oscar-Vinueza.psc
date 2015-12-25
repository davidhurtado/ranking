//Una empresa de turismo ofrece dos paquetes de viaje, en brasil un dolar equivale a 3.84 reales 
//los viajeros son ecuatorianos y desean comprar varios productos pero quieren conocer la relacion de costo en dolares
//realice un pseudocodigo que le permita elegir un paquete tursitico y de acuerdo al pais ingrese el nombre del producto que desea
//adquirir la cantidad y el costo, finalmente muestre el total a pagar, luego pregunte si desea pagar en efectivo o a credito
//y muestre un mensaje que diga transaccion realizada con exito.
Proceso empresa_turismo
	op=0;
	r="";
	np="";
	vp=0;
	cp=0;
	vt=0;
	r2="";
	r3="";
	Escribir "              GORDO TRAVEL              ";
	Escribir "************MENU DE PAQUETES**************";
	Escribir "1.Paquete de viaje a Brasil";
	Escribir "2.Paquete de viaje a Galapagos";
	Escribir "3.Salir del menu";
	Escribir "******************************************"
	Repetir
		Escribir "Por favor ingrese su opcion";
		Leer op;
	Hasta Que op=1 o op=2 o op=3
	Segun op Hacer
		1:
			Escribir "Usted elegio la opcion del paquete a Brasil";
			Escribir "¿Desea conocer el valor de un producto en Brasil?";
			Leer r;
			si r="si" Entonces
				Escribir "ingrese el nombre de su producto";
				Leer np;
				Escribir "ingrese el valor de su producto en Reales";
				Leer vp;
				Escribir "ingrese la cantidad de ",np," que desea adquirir";
				Leer cp;
				vt=(vp/3.84)*cp;
				Escribir "el valor de su producto es de ",vt," Dolares";
				Escribir "¿desea pagar en efectivo o tarjeta de credito?";
				Leer r2;
				Escribir "Transaccion realizada con exito";
				Escribir "Gracias por elegir nuestro servicio";
				Escribir "¿Desea hacer otro calculo?";
				Leer r3;
				Mientras r3="si" Hacer
					Escribir "ingrese el nombre de su producto";
					Leer np;
					Escribir "ingrese el valor de su producto en Reales";
					Leer vp;
					Escribir "ingrese la cantidad de ",np," que desea adquirir";
					Leer cp;
					vt=(vp/3.84)*cp;
					Escribir "el valor de su producto es de ",vt," Dolares";
					Escribir "¿desea pagar en efectivo o tarjeta de credito?";
					Leer r2;
					Escribir "Transaccion realizada con exito";
					Escribir "¿Desea hacer otro calculo?";
					Leer r3;
				Fin Mientras
			Sino
				Escribir "Fin de la transaccion";
				Escribir "Gracias por elegir nuestro servicio";
			FinSi
		2:
			Escribir "Usted elegio la opcion del paquete a las islas Galapagos";
			Escribir "¿Desea conocer el valor de un producto en Galapagos?";
			Leer r;
			si r="si" Entonces
				Escribir "ingrese el nombre de su producto";
				Leer np;
				Escribir "ingrese el valor de su producto";
				Leer vp;
				Escribir "ingrese la cantidad de ",np," que desea adquirir";
				Leer cp;
				vt=vp*cp
				Escribir "el valor en Galapagos de su producto es de ",vt,"Dolares";
				Escribir "¿desea pagar en efectivo o tarjeta de credito?";
				Leer r2;
				Escribir "Transaccion realizada con exito";
				Escribir "¿Desea hacer otro calculo?";
				Leer r3;
				Mientras r3="si" Hacer
					Escribir "ingrese el nombre de su producto";
					Leer np;
					Escribir "ingrese el valor de su producto en Reales";
					Leer vp;
					Escribir "ingrese la cantidad de ",np," que desea adquirir";
					Leer cp;
					vt=vp*cp;
					Escribir "el valor de su producto es de ",vt," Dolares";
					Escribir "¿desea pagar en efectivo o tarjeta de credito?";
					Leer r2;
					Escribir "Transaccion realizada con exito";
					Escribir "¿Desea hacer otro calculo?";
					Leer r3;
				Fin Mientras
				
			Sino
				Escribir "Fin de la transaccion";
				Escribir "Gracias por elegir nuestro servicio";
			FinSi
			
		3:
			Escribir "Fin de la transaccion";
			Escribir "Usted acaba de salir del menu de compra";
		Fin Segun
FinProceso
