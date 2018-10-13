function adicionaLinha()
{
      var inscricaoG  = document.getElementById('valorInscricaoG').value;
      var inscricaoA  = document.getElementById('valorInscricaoA').value;
      var jantar      = document.getElementById('valorJantar').value;
      var almoco      = document.getElementById('valorAlmoco').value;
      //var optJantar   = document.getElementById('jantCas').checked;
      var descontoI  = document.getElementById('descontoInscricao').value;
      var descontoJ  = document.getElementById('descontoJantar').value;
      var transporteValor = document.getElementById('valorTransporte').value;

      //  alert(optJantar);

      var conjvalue = document.getElementById('conjS').checked;

              var teste = document.getElementById('new_as_cod').value.length;
              var teste2 = document.getElementById('new_as_cod2').value.length;

            if ( teste > 5)
            {

              var table = document.getElementById("ficha");
              var insnum = document.getElementById('repeat').value;
              var row = table.insertRow(table.length);
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              var cell3 = row.insertCell(2);
              var cell6 = row.insertCell(3);
              var cellTrans = row.insertCell(4);
              var cell5 = row.insertCell(5);
              
              var ins = document.createElement("input");
              ins.setAttribute("value",document.getElementById("new_as_cod").value);
              ins.setAttribute("id","insNum_"+insnum);
              ins.setAttribute("name","insNum_"+insnum);
              ins.setAttribute("class","is-disabled");
              cell1.appendChild(ins);


              var ins2 = document.createElement("input");
              ins2.setAttribute("value",document.getElementById("as_nome").value);
              ins2.setAttribute("size","30");
              ins2.setAttribute("id","insNome_"+insnum);
              ins2.setAttribute("name","insNome_"+insnum);
              ins2.setAttribute("class","is-disabled");
              cell2.appendChild(ins2);

                                                      var valDescIns = document.createElement("input");
                                                      valDescIns.type = "hidden";
                                                      valDescIns.setAttribute("value","0")
                                                      valDescIns.setAttribute("id","valDescIns_"+insnum);
                                                      valDescIns.setAttribute("name","valDescIns_"+insnum);
                                                      cell3.appendChild(valDescIns);

                                                      var valDescJan = document.createElement("input");
                                                      valDescJan.type = "hidden";
                                                      valDescJan.setAttribute("value","0")
                                                      valDescJan.setAttribute("id","valDescJan_"+insnum);
                                                      valDescJan.setAttribute("name","valDescJan_"+insnum);
                                                      cell3.appendChild(valDescJan);

                      // VALOR DE JANTAR É O MESMO INDEPENDENTE DO MEMBRO                                
                        var ins3 = document.createElement("input");
                        ins3.type = "checkbox";
                        ins3.setAttribute("id","insJanta_"+insnum);
                        ins3.setAttribute("name","insJanta_"+insnum);
                        ins3.setAttribute("onclick","Jantar("+insnum+");somaAll();");
                        cell3.appendChild(ins3);

                                      var valJan = document.createElement("input");
                                      valJan.type = "hidden";
                                      valJan.setAttribute("value","0")
                                      valJan.setAttribute("id","valJan_"+insnum);
                                      valJan.setAttribute("name","valJan_"+insnum);
                                      cell3.appendChild(valJan);
                      //////////////////////////////////////////
                    
              
              if (document.getElementById('as_tipo').value == 'G')
              {
                    
                var ins6 = document.createElement("input");
                ins6.type = "hidden";
                ins6.setAttribute("value","G");
                ins6.setAttribute("id","insTipo_"+insnum);
                ins6.setAttribute("name","insTipo_"+insnum);
                cell6.appendChild(ins6);

    
                var valG = document.createElement("input");
                valG.type = "hidden";
                valG.setAttribute("value",inscricaoG);
                valG.setAttribute("id","val_"+insnum);
                valG.setAttribute("name","val_"+insnum);
                cell1.appendChild(valG);

                var ins5 = document.createElement("input");
                ins5.type = "checkbox";
                ins5.setAttribute("id","insMsg_"+insnum);
                ins5.setAttribute("name","insMsg_"+insnum);
                cell5.appendChild(ins5);

                
              }
              else
              {

                var ins6 = document.createElement("input");
                ins6.type = "hidden";
                ins6.setAttribute("value","A");
                ins6.setAttribute("id","insTipo_"+insnum);
                ins6.setAttribute("name","insTipo_"+insnum);
                cell6.appendChild(ins6);

                /*   var vr = parseInt(document.getElementById("valorTotal").value,10);
                var v2 = 80;
                document.getElementById("valorTotal").value = (vr+v2);*/

                var valA = document.createElement("input");
                valA.type = "hidden";
                valA.setAttribute("value",inscricaoA);
                valA.setAttribute("id","val_"+insnum);
                valA.setAttribute("name","val_"+insnum);
                cell1.appendChild(valA);

                var ins4 = document.createElement("input");
                ins4.type = "checkbox";
                ins4.setAttribute("id","insAlmoco_"+insnum);
                ins4.setAttribute("name","insAlmoco_"+insnum);
                ins4.setAttribute("onclick","Almoco("+insnum+");somaAll();");
                cell6.appendChild(ins4);

                            var valAlm = document.createElement("input");
                            valAlm.type = "hidden";
                            valAlm.setAttribute("value","0")
                            valAlm.setAttribute("id","valAlm_"+insnum);
                            valAlm.setAttribute("name","valAlm_"+insnum);
                            cell6.appendChild(valAlm);

              }

                   //TRANPORTE
                  var trans = document.createElement("input");
                    trans.type = "checkbox";
                    trans.setAttribute("id","insTrans_"+insnum);
                    trans.setAttribute("name","insTrans_"+insnum);
                    trans.setAttribute("onclick","Transporte("+insnum+");somaAll();");
                    cellTrans.appendChild(trans);

                                  var valTrans = document.createElement("input");
                                  valTrans.type = "hidden";
                                  valTrans.setAttribute("value","0")
                                  valTrans.setAttribute("id","valTrans_"+insnum);
                                  valTrans.setAttribute("name","valTrans_"+insnum);
                                  cellTrans.appendChild(valTrans);
                  //////////////////////////
                  tableLines();

            } //Fecha primeira inscrição

              

              if (conjvalue == true && teste2 > 6 )
              {
                      var vr = parseInt(document.getElementById("repeat").value,10);
                      var vr2 = 1;
                      var insnum = vr;
                      var row2 = table.insertRow(table.length);
                      var cell11 = row2.insertCell(0);
                      var cell22 = row2.insertCell(1);
                      var cell33 = row2.insertCell(2);
                      var cell66 = row2.insertCell(3);
                      var cellTrans2 = row2.insertCell(4);
                      var cell55 = row2.insertCell()

                  /*    var but = document.createElement("input");
                      but.type = "button";
                      but.setAttribute("value","Apagar");
                      but.setAttribute("id","btn_"+insnum);
                      but.setAttribute("name","btn_"+insnum);
                      but.setAttribute("onclick","deleteRow(this.parentNode.parentNode.rowIndex);somaAll();");
                      cell66.appendChild(but);*/

                      if (conjvalue == true && teste2 > 6 )
                      {
                        var valDescIns = document.createElement("input");
                                            valDescIns.type = "hidden";
                                            valDescIns.setAttribute("value",descontoI)
                                            valDescIns.setAttribute("id","valDescIns_"+insnum);
                                            valDescIns.setAttribute("name","valDescIns_"+insnum);
                                            cell33.appendChild(valDescIns);
                      }
                      else
                      {
                        var valDescIns = document.createElement("input");
                                            valDescIns.type = "hidden";
                                            valDescIns.setAttribute("value","0")
                                            valDescIns.setAttribute("id","valDescIns_"+insnum);
                                            valDescIns.setAttribute("name","valDescIns_"+insnum);
                                            cell33.appendChild(valDescIns);
                      }

                      
                      var ins = document.createElement("input");
                      ins.setAttribute("value",document.getElementById("new_as_cod2").value);
                      ins.setAttribute("id","insNum_"+insnum);
                      ins.setAttribute("name","insNum_"+insnum);
                      ins.setAttribute("class","is-disabled");

                      var ins2 = document.createElement("input");
                      ins2.setAttribute("value",document.getElementById("as_nome2").value);
                      ins2.setAttribute("size","30");
                      ins2.setAttribute("id","insNome_"+insnum);
                      ins2.setAttribute("name","insNome_"+insnum);
                      ins2.setAttribute("class","is-disabled");

                      cell11.appendChild(ins);
                      cell22.appendChild(ins2);

                                var ins3 = document.createElement("input");
                                ins3.type = "checkbox";
                                ins3.setAttribute("id","insJanta_"+insnum);
                                ins3.setAttribute("name","insJanta_"+insnum);
                                ins3.setAttribute("onclick","Jantar("+insnum+");somaAll();");
                                cell33.appendChild(ins3);

                                              var valJan = document.createElement("input");
                                              valJan.type = "hidden";
                                              valJan.setAttribute("value","0")
                                              valJan.setAttribute("id","valJan_"+insnum);
                                              valJan.setAttribute("name","valJan_"+insnum);
                                              cell33.appendChild(valJan);

                                                    var valDescJan = document.createElement("input");
                                                    valDescJan.type = "hidden";
                                                    valDescJan.setAttribute("value","0")
                                                    valDescJan.setAttribute("id","valDescJan_"+insnum);
                                                    valDescJan.setAttribute("name","valDescJan_"+insnum);
                                                    cell33.appendChild(valDescJan);
                            
                      
                      if (document.getElementById('as_tipo2').value == 'G')
                      {


                        var ins6 = document.createElement("input");
                        ins6.type = "hidden";
                        ins6.setAttribute("value","G");
                        ins6.setAttribute("id","insTipo_"+insnum);
                        ins6.setAttribute("name","insTipo_"+insnum);
                        cell6.appendChild(ins6);

                       /* var vr = parseInt(document.getElementById("valorTotal").value,10);
                        var v2 = 90;
                        document.getElementById("valorTotal").value = (vr+v2);*/

                        var valG = document.createElement("input");
                        valG.type = "hidden";
                        valG.setAttribute("value",inscricaoG);
                        valG.setAttribute("id","val_"+insnum);
                        valG.setAttribute("name","val_"+insnum);
                        cell11.appendChild(valG);

                        var ins5 = document.createElement("input");
                        ins5.type = "checkbox";
                        ins5.setAttribute("id","insMsg_"+insnum);
                        ins5.setAttribute("name","insMsg_"+insnum);
                        cell55.appendChild(ins5);

                      }
                      else
                      {

                        var ins6 = document.createElement("input");
                        ins6.type = "hidden";
                        ins6.setAttribute("value","A");
                        ins6.setAttribute("id","insTipo_"+insnum);
                        ins6.setAttribute("name","insTipo_"+insnum);
                        cell66.appendChild(ins6);

                        var valA = document.createElement("input");
                        valA.type = "hidden";
                        valA.setAttribute("value",inscricaoA);
                        valA.setAttribute("id","val_"+insnum);
                        valA.setAttribute("name","val_"+insnum);
                        cell11.appendChild(valA);

                       /* var vr = parseInt(document.getElementById("valorTotal").value,10);
                        var v2 = 80;
                        document.getElementById("valorTotal").value = (vr+v2);*/

                        var ins4 = document.createElement("input");
                        ins4.type = "checkbox";
                        ins4.setAttribute("id","insAlmoco_"+insnum);
                        ins4.setAttribute("name","insAlmoco_"+insnum);
                        ins4.setAttribute("onclick","Almoco("+insnum+");somaAll();");
                        cell66.appendChild(ins4);

                                    var valAlm = document.createElement("input");
                                    valAlm.type = "hidden";
                                    valAlm.setAttribute("value","0")
                                    valAlm.setAttribute("id","valAlm_"+insnum);
                                    valAlm.setAttribute("name","valAlm_"+insnum);
                                    cell66.appendChild(valAlm);
                      }


                    // TRANSPORTE  
                      var trans2 = document.createElement("input");
                      trans2.type = "checkbox";
                      trans2.setAttribute("id","insTrans_"+insnum);
                      trans2.setAttribute("name","insTrans_"+insnum);
                      trans2.setAttribute("onclick","Transporte("+insnum+");somaAll();");
                      cellTrans2.appendChild(trans2);

                                    var valTrans2 = document.createElement("input");
                                    valTrans2.type = "hidden";
                                    valTrans2.setAttribute("value","0")
                                    valTrans2.setAttribute("id","valTrans_"+insnum);
                                    valTrans2.setAttribute("name","valTrans_"+insnum);
                                    cellTrans2.appendChild(valTrans2);
                    /////////////////////////*/

                    tableLines();
              } // fecha inscrição conjuge

             

           /*   var but = document.createElement("input");
              but.type = "button";
              but.setAttribute("value","Apagar");
              but.setAttribute("id","btn_"+insnum);
              but.setAttribute("name","btn_"+insnum);
              but.setAttribute("onclick","deleteRow(this.parentNode.parentNode.rowIndex);somaAll();");
              cell6.appendChild(but);*/

              document.getElementById('new_as_cod').value = '';
              document.getElementById('new_as_cod2').value = '';
              document.getElementById('as_nome').value = '';
              document.getElementById('as_nome2').value = '';
              document.getElementById('as_email').value = '';
              document.getElementById('as_email2').value = '';
              document.getElementById('aliasMem1').value = '';
              document.getElementById('aliasMem2').value = '';

              somaDesc();
              somaAll();                             
}

  function adicionaVis()
{
     var teste = document.getElementById('nomeVis').value.length;
     var inscricaoV = document.getElementById('valorInscricaoV').value;
     var transporteValor = document.getElementById('valorTransporte').value;
     var almoco      = document.getElementById('valorAlmoco').value;

            if ( teste > 5)
            {

              var table = document.getElementById("ficha");
              var insnum = document.getElementById("repeat").value;

              var row = table.insertRow(table.length);
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              var cell3 = row.insertCell(2);
              var cell6 = row.insertCell(3);
              var cellTransV = row.insertCell(4);

            /*  var but = document.createElement("input");
              but.type = "button";
              but.setAttribute("value","Apagar");
              but.setAttribute("id","btn_"+insnum);
              but.setAttribute("name","btn_"+insnum);
              but.setAttribute("onclick","deleteRow(this.parentNode.parentNode.rowIndex);somaAll();");
              cell6.appendChild(but);*/
              
              var ins = document.createElement("input");
              ins.setAttribute("value","99000"+insnum);
              ins.setAttribute("id","insNum_"+insnum);
              ins.setAttribute("name","insNum_"+insnum);
              ins.setAttribute("class","is-disabled");

              var ins2 = document.createElement("input");
              ins2.setAttribute("value",document.getElementById("nomeVis").value);
              ins2.setAttribute("size","30");
              ins2.setAttribute("id","insNome_"+insnum);
              ins2.setAttribute("name","insNome_"+insnum);
              ins2.setAttribute("class","is-disabled");

              cell1.appendChild(ins);
              cell2.appendChild(ins2);

             
              
              if (document.getElementById("genderM").checked)
              {

                var ins3 = document.createElement("input");
                ins3.type = "checkbox";
                ins3.setAttribute("id","insJanta_"+insnum);
                ins3.setAttribute("name","insJanta_"+insnum);
                ins3.setAttribute("onclick","Jantar("+insnum+");somaAll();");
                cell3.appendChild(ins3);

                              var valJan = document.createElement("input");
                              valJan.type = "hidden";
                              valJan.setAttribute("value","0")
                              valJan.setAttribute("id","valJan_"+insnum);
                              valJan.setAttribute("name","valJan_"+insnum);
                              cell3.appendChild(valJan);

                              var insGen = document.createElement("input");
                              insGen.type = "hidden";
                              insGen.setAttribute("value","M")
                              insGen.setAttribute("id","insGen_"+insnum);
                              insGen.setAttribute("name","insGen_"+insnum);
                              cell3.appendChild(insGen);

              }
              else if (document.getElementById("genderF").checked)
              {
                var ins3 = document.createElement("input");
                ins3.type = "checkbox";
                ins3.setAttribute("id","insJanta_"+insnum);
                ins3.setAttribute("name","insJanta_"+insnum);
                ins3.setAttribute("onclick","Jantar("+insnum+");somaAll();");
                cell3.appendChild(ins3);

                              var valJan = document.createElement("input");
                              valJan.type = "hidden";
                              valJan.setAttribute("value","0")
                              valJan.setAttribute("id","valJan_"+insnum);
                              valJan.setAttribute("name","valJan_"+insnum);
                              cell3.appendChild(valJan);

                              var insGen = document.createElement("input");
                              insGen.type = "hidden";
                              insGen.setAttribute("value","F")
                              insGen.setAttribute("id","insGen_"+insnum);
                              insGen.setAttribute("name","insGen_"+insnum);
                              cell3.appendChild(insGen);

                var ins4 = document.createElement("input");
                ins4.type = "checkbox";
                ins4.setAttribute("id","insAlmoco_"+insnum);
                ins4.setAttribute("name","insAlmoco_"+insnum);
                ins4.setAttribute("onclick","Almoco("+insnum+");somaAll();");
                cell6.appendChild(ins4);

                            var valAlm = document.createElement("input");
                            valAlm.type = "hidden";
                            valAlm.setAttribute("value","0")
                            valAlm.setAttribute("id","valAlm_"+insnum);
                            valAlm.setAttribute("name","valAlm_"+insnum);
                            cell6.appendChild(valAlm);
                
              
              }

                        var ins6 = document.createElement("input");
                        ins6.type = "hidden";
                        ins6.setAttribute("value","V");
                        ins6.setAttribute("id","insTipo_"+insnum);
                        ins6.setAttribute("name","insTipo_"+insnum);
                        cell6.appendChild(ins6);


                        var ins8 = document.createElement("input");
                        ins8.type = "hidden";
                        ins8.setAttribute("value",document.getElementById("aliasVis").value);
                        ins8.setAttribute("id","insAlias_"+insnum);
                        ins8.setAttribute("name","insAlias_"+insnum);
                        cell6.appendChild(ins8);

                                if (document.getElementById("pastS").checked)
                                  {

                                    var ins9 = document.createElement("input");
                                    ins9.type = "hidden";
                                    ins9.setAttribute("value","1");
                                    ins9.setAttribute("id","insPast_"+insnum);
                                    ins9.setAttribute("name","insPast_"+insnum);
                                    cell6.appendChild(ins9);

                                    var valV = document.createElement("input");
                                    valV.type = "hidden";
                                    valV.setAttribute("value","0");
                                    valV.setAttribute("id","val_"+insnum);
                                    valV.setAttribute("name","val_"+insnum);
                                    cell1.appendChild(valV);

                                  }
                                  else if (document.getElementById("pastN").checked)
                                  {
                                    var ins9 = document.createElement("input");
                                    ins9.type = "hidden";
                                    ins9.setAttribute("value","0");
                                    ins9.setAttribute("id","insPast_"+insnum);
                                    ins9.setAttribute("name","insPast_"+insnum);
                                    cell6.appendChild(ins9);

                                    var valV = document.createElement("input");
                                    valV.type = "hidden";
                                    valV.setAttribute("value",inscricaoV);
                                    valV.setAttribute("id","val_"+insnum);
                                    valV.setAttribute("name","val_"+insnum);
                                    cell1.appendChild(valV);
                                  }

                         // TRANSPORTE  
                      var transV = document.createElement("input");
                      transV.type = "checkbox";
                      transV.setAttribute("id","insTrans_"+insnum);
                      transV.setAttribute("name","insTrans_"+insnum);
                      transV.setAttribute("onclick","Transporte("+insnum+");somaAll();");
                      cellTransV.appendChild(transV);

                                    var valTransV = document.createElement("input");
                                    valTransV.type = "hidden";
                                    valTransV.setAttribute("value","0")
                                    valTransV.setAttribute("id","valTrans_"+insnum);
                                    valTransV.setAttribute("name","valTrans_"+insnum);
                                    cellTransV.appendChild(valTransV);
                    //////////////////////////

                        tableLines();
                        somaAll();

            }    // FECHA IF 
}

  function adicionaChild()
  {
    var inscricaoC  = document.getElementById('valorInscricaoC').value;
    var criancaEvOpt = document.getElementById('idCriancaEvOpt').value;
     var teste = document.getElementById('nomeChild').value.length;
     var teste2 = document.getElementById('idadeChild').value;

            if ( teste > 6 && teste2 >= 0)
            {

              var table = document.getElementById("ficha");
              var insnum = document.getElementById('repeat').value;
              var row = table.insertRow(table.length);
              var cell1 = row.insertCell(0);
              var cell2 = row.insertCell(1);
              var cell3 = row.insertCell(2);
              var cell6 = row.insertCell(3);
              var cell7 = row.insertCell(4);
              var cell8 = row.insertCell(5);

            /*  var but = document.createElement("input");
              but.type = "button";
              but.setAttribute("value","Apagar");
              but.setAttribute("id","btn_"+insnum);
              but.setAttribute("name","btn_"+insnum);
              but.setAttribute("onclick","deleteRow(this.parentNode.parentNode.rowIndex);somaAll();");
              cell6.appendChild(but);*/
              
              var ins = document.createElement("input");
              ins.setAttribute("value","99000"+insnum);
              ins.setAttribute("id","insNum_"+insnum);
              ins.setAttribute("size","10");
              ins.setAttribute("name","insNum_"+insnum);
              ins.setAttribute("class","is-disabled");

              var ins2 = document.createElement("input");
              ins2.setAttribute("value",document.getElementById("nomeChild").value);
              ins2.setAttribute("id","insNome_"+insnum);
              ins2.setAttribute("name","insNome_"+insnum);
              ins2.setAttribute("class","is-disabled");

              cell1.appendChild(ins);
              cell2.appendChild(ins2);

              var ins6 = document.createElement("input");
              ins6.type = "hidden";
              ins6.setAttribute("value","C");
              ins6.setAttribute("id","insTipo_"+insnum);
              ins6.setAttribute("name","insTipo_"+insnum);
              cell6.appendChild(ins6);

              var ins7 = document.createElement("input");
              ins7.type = "hidden";
              ins7.setAttribute("value",document.getElementById("idadeChild").value);
              ins7.setAttribute("id","insIdade_"+insnum);
              ins7.setAttribute("name","insIdade_"+insnum);
              cell6.appendChild(ins7);

              var ins14 = document.createElement("input");
              ins14.type = "hidden";
              ins14.setAttribute("value",document.getElementById("aliasChild").value);
              ins14.setAttribute("id","insAlias_"+insnum);
              ins14.setAttribute("name","insAlias_"+insnum);
              cell6.appendChild(ins14);


                //PARTICULARIDADES DE CADA CRIANÇA
                  //// FEBRE
                    if (document.getElementById("febreS").checked)
                    {
                      var ins8 = document.createElement("input");
                      ins8.type = "hidden";
                      ins8.setAttribute("value","1");
                      ins8.setAttribute("id","insFebre_"+insnum);
                      ins8.setAttribute("name","insFebre_"+insnum);
                      cell6.appendChild(ins8);

                      var ins9 = document.createElement("input");
                      ins9.type = "hidden";
                      ins9.setAttribute("value",document.getElementById('febreDesc').value);
                      ins9.setAttribute("id","insFebreDesc_"+insnum);
                      ins9.setAttribute("name","insFebreDesc_"+insnum);
                      cell6.appendChild(ins9);

                    }
                    else if (document.getElementById("febreN").checked)
                    {

                      var ins8 = document.createElement("input");
                      ins8.type = "hidden";
                      ins8.setAttribute("value","0");
                      ins8.setAttribute("id","insFebre_"+insnum);
                      ins8.setAttribute("name","insFebre_"+insnum);
                      cell6.appendChild(ins8);

                      var ins9 = document.createElement("input");
                      ins9.type = "hidden";
                      ins9.setAttribute("value"," ");
                      ins9.setAttribute("id","insFebreDesc_"+insnum);
                      ins9.setAttribute("name","insFebreDesc_"+insnum);
                      cell6.appendChild(ins9);
                      
                    }

                  ////ALERGIA
                    if (document.getElementById("alergiaS").checked)
                    {

                      var ins10 = document.createElement("input");
                      ins10.type = "hidden";
                      ins10.setAttribute("value","1");
                      ins10.setAttribute("id","insAlergia_"+insnum);
                      ins10.setAttribute("name","insAlergia_"+insnum);
                      cell6.appendChild(ins10);

                      var ins11 = document.createElement("input");
                      ins11.type = "hidden";
                      ins11.setAttribute("value",document.getElementById('alergiaDesc').value);
                      ins11.setAttribute("id","insAlegiaDesc_"+insnum);
                      ins11.setAttribute("name","insAlergiaDesc_"+insnum);
                      cell6.appendChild(ins11);

                    }
                    else if (document.getElementById("alergiaN").checked)
                    {
                      var ins10 = document.createElement("input");
                      ins10.type = "hidden";
                      ins10.setAttribute("value","0");
                      ins10.setAttribute("id","insAlergia_"+insnum);
                      ins10.setAttribute("name","insAlergia_"+insnum);
                      cell6.appendChild(ins10);

                      var ins11 = document.createElement("input");
                      ins11.type = "hidden";
                      ins11.setAttribute("value"," ");
                      ins11.setAttribute("id","insAlegiaDesc_"+insnum);
                      ins11.setAttribute("name","insAlergiaDesc_"+insnum);
                      cell6.appendChild(ins11);

                    }

                  ////RESTRIÇÃO
                    if (document.getElementById("restricaoS").checked)
                    {
                      var ins12 = document.createElement("input");
                      ins12.type = "hidden";
                      ins12.setAttribute("value","1");
                      ins12.setAttribute("id","insRestricao_"+insnum);
                      ins12.setAttribute("name","insRestricao_"+insnum);
                      cell6.appendChild(ins12);

                      var ins13 = document.createElement("input");
                      ins13.type = "hidden";
                      ins13.setAttribute("value",document.getElementById('restricaoDesc').value);
                      ins13.setAttribute("id","insRestricaoDesc_"+insnum);
                      ins13.setAttribute("name","insRestricaoDesc_"+insnum);
                      cell6.appendChild(ins13);

                    }
                    else if (document.getElementById("restricaoN").checked)
                    {
                      var ins12 = document.createElement("input");
                      ins12.type = "hidden";
                      ins12.setAttribute("value","0");
                      ins12.setAttribute("id","insRestricao_"+insnum);
                      ins12.setAttribute("name","insRestricao_"+insnum);
                      cell6.appendChild(ins12);

                      var ins13 = document.createElement("input");
                      ins13.type = "hidden";
                      ins13.setAttribute("value"," ");
                      ins13.setAttribute("id","insRestricaoDesc_"+insnum);
                      ins13.setAttribute("name","insRestricaoDesc_"+insnum);
                      cell6.appendChild(ins13);
                      
                    }
                ////////////////////////////////////

                var valC = document.createElement("input");
                valC.type = "hidden";
                valC.setAttribute("value",inscricaoC);
                valC.setAttribute("id","val_"+insnum);
                valC.setAttribute("name","val_"+insnum);
                cell1.appendChild(valC);

                var valId = document.createElement("input");
                valId.type = "hidden";
                valId.setAttribute("value",criancaEvOpt);
                valId.setAttribute("id","val_idopt_"+insnum);
                valId.setAttribute("name","val_idopt_"+insnum);
                cell1.appendChild(valId);
              

              tableLines();
              somaAll();
              }
            else
            {
              alert("Campo 'Nome' ou 'Idade' preenchido de maneira incorreta.\n Nome e Sobrenome deve possuir mais que 6 letras.\n Idade tem que ser maior que 0");
            }
  }

  function exibe(id) {  
    if(document.getElementById(id).style.display=="none") {  
        document.getElementById(id).style.display = "inline";  
    }      }

  function disexibe(id) {  
    if(document.getElementById(id).style.display=="inline") {  
        document.getElementById(id).style.display = "none";  
    }  }


  function addPayment()
  {

        var table = document.getElementById("payInfo");
        var insnum = table.rows.length;
        if (document.getElementById("cc_nome").value.length > 4 &&
            document.getElementById("cc_num1").value.length > 3 &&
            document.getElementById("cc_num2").value.length > 3 &&
            document.getElementById("cc_num3").value.length > 3 &&
            document.getElementById("cc_num4").value.length > 1 &&
            document.getElementById("cc_cod").value.length > 2 )
        {
              if (insnum <= 1)
              {

                  var row = table.insertRow(table.rows.length);
                  var cell1 = row.insertCell(0);

                  var row2 = table.insertRow(table.rows.length);
                  var cell2 = row2.insertCell(0);

                  var row3 = table.insertRow(table.rows.length);
                  var cell3 = row3.insertCell(0);

                  var row4 = table.insertRow(table.rows.length);
                  var cell4 = row4.insertCell(0);

                  var ins = document.createElement("input");
                  ins.setAttribute("value",document.getElementById("cc_nome").value);
                  ins.setAttribute("id","pay_ccnome");
                  ins.setAttribute("name","pay_ccnome");
                  ins.setAttribute("class","is-disabled");

                  var ins2 = document.createElement("input");
                  ins2.setAttribute("value","****************"+document.getElementById("cc_num4").value);
                  ins2.setAttribute("class","is-disabled");
                  
                  var ins3 = document.createElement("input");
                  ins3.type = "hidden";
                  ins3.setAttribute("value",document.getElementById("cc_num1").value+document.getElementById("cc_num2").value+document.getElementById("cc_num3").value+document.getElementById("cc_num4").value);
                  ins3.setAttribute("id","pay_ccnum");
                  ins3.setAttribute("name","pay_ccnum");

                  var ins4 = document.createElement("input");
                  ins4.setAttribute("value",document.getElementById("cc_mes").value+"/"+document.getElementById("cc_ano").value);
                  ins4.setAttribute("id","pay_ccvencto");
                  ins4.setAttribute("name","pay_ccvencto");
                  ins4.setAttribute("class","is-disabled");

                  var ins5 = document.createElement("input");
                  ins5.setAttribute("value","Parcelas: "+document.getElementById("parc").value);
                  ins5.setAttribute("class","is-disabled");

                  var ins6 = document.createElement("input");
                  ins6.type = "hidden";
                  ins6.setAttribute("value",document.getElementById("parc").value);
                  ins6.setAttribute("id","pay_ccparc");
                  ins6.setAttribute("name","pay_ccparc");

                  var ins7 = document.createElement("input");
                  ins7.type = "hidden";
                  ins7.setAttribute("value",document.getElementById("cc_cod").value);
                  ins7.setAttribute("id","pay_ccverso");
                  ins7.setAttribute("name","pay_ccverso");


                  cell1.appendChild(ins);
                  cell2.appendChild(ins2);
                  cell2.appendChild(ins3);
                  cell3.appendChild(ins4);
                  cell4.appendChild(ins5);
                  cell4.appendChild(ins6);
                  cell4.appendChild(ins7);

                  document.getElementById('flag').value = 1;

              }
              else
              {
                 if (insnum == 2)
                  {
                    table.deleteRow(table.rows.length-1);
                  }
                  else
                  {
                    table.deleteRow(table.rows.length-1);
                    table.deleteRow(table.rows.length-1);
                    table.deleteRow(table.rows.length-1);
                    table.deleteRow(table.rows.length-1);
                  }
                  

                  var row = table.insertRow(table.rows.length);
                  var cell1 = row.insertCell(0);

                  var row2 = table.insertRow(table.rows.length);
                  var cell2 = row2.insertCell(0);

                  var row3 = table.insertRow(table.rows.length);
                  var cell3 = row3.insertCell(0);

                  var row4 = table.insertRow(table.rows.length);
                  var cell4 = row4.insertCell(0);

                  var ins = document.createElement("input");
                  ins.setAttribute("value",document.getElementById("cc_nome").value);
                  ins.setAttribute("id","pay_ccnome");
                  ins.setAttribute("name","pay_ccnome");
                  ins.setAttribute("class","is-disabled");

                  var ins2 = document.createElement("input");
                  ins2.setAttribute("value","****************"+document.getElementById("cc_num4").value);
                  ins2.setAttribute("class","is-disabled");
                  
                  var ins3 = document.createElement("input");
                  ins3.type = "hidden";
                  ins3.setAttribute("value",document.getElementById("cc_num1").value+document.getElementById("cc_num2").value+document.getElementById("cc_num3").value+document.getElementById("cc_num4").value);
                  ins3.setAttribute("id","pay_ccnum");
                  ins3.setAttribute("name","pay_ccnum");

                  var ins4 = document.createElement("input");
                  ins4.setAttribute("value",document.getElementById("cc_mes").value+"/"+document.getElementById("cc_ano").value);
                  ins4.setAttribute("id","pay_ccvencto");
                  ins4.setAttribute("name","pay_ccvencto");
                  ins4.setAttribute("class","is-disabled");

                  var ins5 = document.createElement("input");
                  ins5.setAttribute("value","Parcelas: "+document.getElementById("parc").value);
                  ins5.setAttribute("class","is-disabled");

                  var ins6 = document.createElement("input");
                  ins6.type = "hidden";
                  ins6.setAttribute("value",document.getElementById("parc").value);
                  ins6.setAttribute("id","pay_ccparc");
                  ins6.setAttribute("name","pay_ccparc");


                  var ins7 = document.createElement("input");
                  ins7.type = "hidden";
                  ins7.setAttribute("value",document.getElementById("cc_cod").value);
                  ins7.setAttribute("id","pay_ccverso");
                  ins7.setAttribute("name","pay_ccverso");


                  cell1.appendChild(ins);
                  cell2.appendChild(ins2);
                  cell2.appendChild(ins3);
                  cell3.appendChild(ins4);
                  cell4.appendChild(ins5);
                  cell4.appendChild(ins6);
                  cell4.appendChild(ins7);

                  document.getElementById('flag').value = 1;

              }
              tableLinesPG();  
      }
      else
      {
        alert('Para adicionar a forma de pagamento Cartão de Crédito é necessário preencher os campos com os dados do seu cartão');
      }      
  }


  function addPaymentB() 
  {

           var table = document.getElementById("payInfo");
            var insnum = table.rows.length;

              if (insnum <= 1)
              {

                  var row = table.insertRow(table.rows.length);
                  var cell1 = row.insertCell(0);

                  var ins = document.createElement("input");
                  ins.setAttribute("value","Boleto Bancário");
                  ins.setAttribute("class","is-disabled");

                  cell1.appendChild(ins);
              }
              else
              {
                if (insnum == 2)
                {

                  table.deleteRow(table.rows.length-1);
                  var row = table.insertRow(table.rows.length);
                  var cell1 = row.insertCell(0);

                  var ins = document.createElement("input");
                  ins.setAttribute("value","Boleto Bancário");
                  ins.setAttribute("class","is-disabled");

                  cell1.appendChild(ins);
                }
                else
                {
                  table.deleteRow(table.rows.length-1);
                  table.deleteRow(table.rows.length-1);
                  table.deleteRow(table.rows.length-1);
                  table.deleteRow(table.rows.length-1);

                  var row = table.insertRow(table.rows.length);
                  var cell1 = row.insertCell(0);

                  var ins = document.createElement("input");
                  ins.setAttribute("value","Boleto Bancário");
                  ins.setAttribute("class","is-disabled");

                  cell1.appendChild(ins);

                }
              }

                  document.getElementById('flag').value = 2;
                  tableLinesPG();
  }

  function tableLines()
  {
                var table = document.getElementById("ficha");
                var row = table.rows.length-1;

                var vr = parseInt(document.getElementById("repeat").value,10);
                var vr2 = 1;

                document.getElementById("lines").value = row;
                document.getElementById("repeat").value = (vr+vr2);
  }

  function tableLinesPG()
  {
    var table = document.getElementById("payInfo");
    var tablelines = table.rows.length;

    document.getElementById('linesPG').value = tablelines-1;
  }

  function Jantar(insnum)
  {
    var vr = parseInt(document.getElementById("valJan_"+insnum).value,10);
    var v2 = parseInt(document.getElementById("valorJantar").value,10);

    if (document.getElementById("insJanta_"+insnum).checked == true)
    {
        if (document.getElementById("insTipo_"+insnum).value == 'V')
        {
          if (document.getElementById("insPast_"+insnum).value  == '1')
          {
                
          }
          else
          {
                
                document.getElementById("valJan_"+insnum).value = (vr+v2);
          }

        }
        else
        {
                document.getElementById("valJan_"+insnum).value = (vr+v2);
        }
                
    }
    else
    {
      if (document.getElementById("insTipo_"+insnum).value  == 'V')
        {
          if (document.getElementById("insPast_"+insnum).value == '1')
          {
                
          }
          else
          {
                document.getElementById("valJan_"+insnum).value = (vr-v2);
          }

        }
        else
        {
                
                document.getElementById("valJan_"+insnum).value = (vr-v2);
        }
    }              
  }

   function Almoco(insnum)
  {
    if (document.getElementById("insAlmoco_"+insnum).checked == true)
    {
        if (document.getElementById("insTipo_"+insnum).value == 'V')
        {
          if (document.getElementById("insPast_"+insnum).value  == '1')
          {
                
          }
          else
          {
                var vr = parseInt(document.getElementById("valAlm_"+insnum).value,10);
                var v2 = parseInt(document.getElementById("valorAlmoco").value,10);
                document.getElementById("valAlm_"+insnum).value = (vr+v2);
          }

        }
        else
        {
                var vr = parseInt(document.getElementById("valAlm_"+insnum).value,10);
                var v2 = parseInt(document.getElementById("valorAlmoco").value,10);
                document.getElementById("valAlm_"+insnum).value = (vr+v2);
        }
                
    }
    else
    {
      if (document.getElementById("insTipo_"+insnum).value  == 'V')
        {
          if (document.getElementById("insPast_"+insnum).value == '1')
          {
               
          }
          else
          {
                var vr = parseInt(document.getElementById("valAlm_"+insnum).value,10);
                var v2 = parseInt(document.getElementById("valorAlmoco").value,10);
                document.getElementById("valAlm_"+insnum).value = (vr-v2);
          }

        }
        else
        {
                var vr = parseInt(document.getElementById("valAlm_"+insnum).value,10);
                var v2 = parseInt(document.getElementById("valorAlmoco").value,10);
                document.getElementById("valAlm_"+insnum).value = (vr-v2);
        }
    }           
  }

   function Transporte(insnum)
  {
    var vr = parseInt(document.getElementById("valTrans_"+insnum).value,10);
    var v2 = parseInt(document.getElementById("valorTransporte").value,10);

    if (document.getElementById("insTrans_"+insnum).checked == true)
    {
                document.getElementById("valTrans_"+insnum).value = (vr+v2);      
    }
    else
    {        
                document.getElementById("valTrans_"+insnum).value = (vr-v2);
    }              
  }

  function validate(evt) 
  {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

  function finalizaSubmit()
  {
    var lines = document.getElementById('lines').value;
    var linhasTabela = document.getElementById('ficha').rows.length;
    if (linhasTabela < 2 )
    {

        alert('Você precisa adicionar alguém na ficha de inscrição e uma forma de pagamento para finalizar');
        return false;

    }
    else
    {
      return true;
    }
  }

/*  function deleteRow(insnum)
  {
    document.getElementById("ficha").deleteRow(insnum);
  }*/

  function isset(_var)
  {
     return !!_var; // converting to boolean.
  }

  function somaAll()
  {
    var repeat = document.getElementById('repeat').value;
    var vrIns = 0;
    var vrAlm = 0;
    var vrJan = 0;
    var vrTrans = 0;

    if (repeat >= 1)
    {
        for (var i = 1; i <= repeat; i++)
        {
          

          if (isset(document.getElementById("insTipo_"+i)) == true) 
          {

                switch(document.getElementById("insTipo_"+i).value)
                {
                  case "G":
                          vrIns = vrIns + parseInt(document.getElementById("val_"+i).value,10);
                          vrJan = vrJan + parseInt(document.getElementById("valJan_"+i).value,10);
                          vrTrans = vrTrans + parseInt(document.getElementById("valTrans_"+i).value,10);
                    break;

                  case "A":
                          vrIns = vrIns + parseInt(document.getElementById("val_"+i).value,10);
                          vrJan = vrJan + parseInt(document.getElementById("valJan_"+i).value,10);
                          vrAlm = vrAlm + parseInt(document.getElementById("valAlm_"+i).value,10);
                          vrTrans = vrTrans + parseInt(document.getElementById("valTrans_"+i).value,10);
                    break;

                  case "V":
                    if (document.getElementById("insGen_"+i).value == "M")
                        {
                          vrIns = vrIns + parseInt(document.getElementById("val_"+i).value,10);
                          vrJan = vrJan + parseInt(document.getElementById("valJan_"+i).value,10);
                          vrTrans = vrTrans + parseInt(document.getElementById("valTrans_"+i).value,10);
                        }
                        else 
                        {
                          vrIns = vrIns + parseInt(document.getElementById("val_"+i).value,10);
                          vrJan = vrJan + parseInt(document.getElementById("valJan_"+i).value,10);
                          vrAlm = vrAlm + parseInt(document.getElementById("valAlm_"+i).value,10);
                          vrTrans = vrTrans + parseInt(document.getElementById("valTrans_"+i).value,10);
                        }
                    break;

                  case "C":
                        vrIns = vrIns + parseInt(document.getElementById("val_"+i).value,10);
                    break;

                    default:
                        vrIns = 0;
                        //vrAlm = 0;
                        vrJan = 0;
                        break;
                }
          }
        }
    }
    else
    {
                  vrIns = 0;
                  vrAlm = 0;
                  vrJan = 0;
                  var vrTrans = 0;
                  document.getElementById("valorTotal").value = 0;
    }

    document.getElementById("valorTotal").value = (vrIns+vrJan+vrTrans+vrAlm);
    document.getElementById("totalPG").value = parseInt(document.getElementById("valorTotal").value,10) - parseInt(document.getElementById("desconto").value,10);
  }


  function somaDesc()
  {
    var repeat = document.getElementById('repeat').value;
    var vrDescInsc = 0;
    //var vrAlm = 0;
    var vrDescJan = 0;
    //var vrTrans = 0;

    if (repeat >= 1)
    {
        for (var i = 1; i <= repeat; i++)
        {

          if (isset(document.getElementById("insTipo_"+i)) == true) 
          {

              if (parseInt(document.getElementById("valDescIns_"+i).value,10) == null)
              {

              }
              else
              {
                vrDescInsc = vrDescInsc + parseInt(document.getElementById("valDescIns_"+i).value,10);
              }

              if (parseInt(document.getElementById("valDescJan_"+i).value,10) == null)
              {

              }
              else
              {
                vrDescJan = vrDescJan + parseInt(document.getElementById("valDescJan_"+i).value,10);
              }

          }

        }
    }
    else
    {
                  vrDescInsc = 0;
                  vrDescJan = 0;
                  document.getElementById("desconto").value = 0;
    }

    document.getElementById("desconto").value = (vrDescInsc+vrDescJan);
  }