<template>
    <v-app>
        <v-col cols="12" sm="5">
            <v-card>
                <div class="my-2">
                    <v-btn class="mx-2 my-2" fab dark small color="primary">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </v-btn>
                    <v-btn color="primary">LISTADO DE CLIENTES</v-btn>
                </div>
                <v-form>
                    <v-container>
                        <v-row class="mb-0" style="height: 70px;">
                            <v-col cols="12" sm="6" class="mb-0" style="height: 0px;">
                                <label for="codigo" class="text-righ"><b>Código</b></label>
                                <v-text-field v-model="codigo" class="pb-0 mb-0" solo></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <label for="dni" class="text-righ"><b>DNI/RUC</b></label>
                                <v-text-field v-model="dni" hide-details solo></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row style="height: 70px;">
                            <v-col cols="12" sm="12">
                                <label for="nombre" class="text-righ"><b>Nombre</b></label>
                                <v-text-field v-model="nombre" hide-details solo></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row style="height: 70px;">
                            <v-col cols="12" sm="8">
                                <label for="telefono" class="text-righ"><b>Teléfono</b></label>
                                <v-text-field v-model="telefono" solo></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="tramo" class="text-righ"><b>Tramo</b></label>
                                <v-text-field v-model="tramo" solo></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="py-0 my-0" style="height: 70px;">
                            <v-col cols="12" sm="12">
                                <label for="ult_gestion" class="text-righ"><b>Ult.Gestión</b></label>
                                <v-text-field v-model="ult_gestion" hide-details solo></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row style="height: 70px;">
                            <v-col cols="12" sm="6">
                                <label for="pdp_desde" class="text-righ"><b>PDP Desde</b></label>
                                <v-text-field v-model="telefono" solo></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <label for="pdp_hasta" class="text-righ"><b>PDP Hasta</b></label>
                                <v-text-field v-model="tramo" solo></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row style="height: 70px;">
                            <v-col cols="12" sm="6">
                                <label for="ordenar" class="text-righ"><b>Ordenar</b></label>
                                <v-text-field v-model="ordenar" solo></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <label for="listar_camp" class="text-righ"><b>Listar Campaña</b></label>
                                <v-text-field v-model="listar_camp" solo></v-text-field>
                            </v-col>
                        </v-row>
                        <div class="my-2">
                            <v-btn class="mx-2 my-2" color="primary">
                                Buscar
                            </v-btn>
                            <v-btn color="primary">Limpiar</v-btn>
                        </div>
                    </v-container>
                </v-form>
            </v-card>

            <v-card>
                <div class="my-2">
                    <v-btn class="mx-2 my-2" fab dark small color="primary">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </v-btn>
                    <v-btn color="primary">DATOS DEL MES</v-btn>
                </div>
                <v-form>
                    <v-container>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8" class="mb-0" style="height: 0px;">
                                <label for="codigo" class="text-left">META ASIGNADA</label>
                            </v-col>
                            <v-col cols="12" sm="4" class="mb-0" style="height: 0px;">
                                <label for="codigo" class="text-righ">S/.50,000</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="nombre" class="text-righ">RECUPERO AL 15</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">S/.25,000</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="telefono" class="text-righ">ALCANCE DE META</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">50%</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="tramo" class="text-righ">EFECTIVIDAD SOBRE PDPS</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">65%</label>
                            </v-col>
                        </v-row>
                        <v-row class="py-0 my-0" style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="ult_gestion" class="text-righ">PDPS CAÍDAS(S/.)</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">S/.11,000</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="pdp_desde" class="text-righ">PDPS PENDIENTES(S/.)</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">S/.33,000</label>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-card>

            <v-card>
                <div class="mt-2">
                    <v-btn class="mx-2 mt-2" fab dark small color="primary">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </v-btn>
                    <v-btn color="primary">ESTÁNDAR</v-btn>
                </div>
                <v-form>
                    <v-container>
                        <v-row style="height: 50px;">
                            <v-col cols="12" sm="2">
                                <v-text-field v-model="ult_gestion" hide-details solo></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <v-btn color="primary">Consultar</v-btn>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8" class="mb-0" style="height: 0px;">
                                <label for="codigo" class="text-left">GESTIONES</label>
                            </v-col>
                            <v-col cols="12" sm="4" class="mb-0" style="height: 0px;">
                                <label for="codigo" class="text-righ">200</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="nombre" class="text-righ">CONTACTOS</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">40</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="telefono" class="text-righ">CONTACTABILIDAD</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">20%</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="tramo" class="text-righ">PDPS</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">2</label>
                            </v-col>
                        </v-row>
                        <v-row class="py-0 my-0" style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="ult_gestion" class="text-righ">MONTO PDPS</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">S/.1,000</label>
                            </v-col>
                        </v-row>
                        <v-row style="height: 30px;">
                            <v-col cols="12" sm="8">
                                <label for="pdp_desde" class="text-righ">MONTO CONFIRMACIONES</label>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <label for="codigo" class="text-righ">S/.1,500</label>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-card>
        </v-col>
    </v-app>
</template>