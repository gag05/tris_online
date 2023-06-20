import numpy as np

def controllo_vincita(turno,p,row,col,diag):
    vinc = False

    if(turno>=5):
        g = 1 if p else -1

        if((row==g*3).any() ):
            return True
        elif((col==g*3).any() ):
            return True
        elif((diag==g*3).any() ):
            return True
        else:
            return False
    else:
        return False
    
def valuta_posizione(situazione):
    numV_x, numV_o = 0,0

    #controlls row
    for i in situazione:
        if( np.any(i[:]==1) and np.any(i[:]==-1)):   
            continue
        elif(np.any(i[:]==1)):
            numV_x += 1
        elif(np.any(i[:]==-1)):
            numV_o += 1

    #controlls col
    for i in range(3):
        if(np.any(situazione[:,i]==1) and np.any(situazione[:,i]==-1)):
            continue
        elif(np.any(situazione[:,i]==1)):
            numV_x += 1
        elif(np.any(situazione[:,i]==-1)):
            numV_o += 1
    
    #controlls diag
    if(np.any(np.diag(situazione)==1) and np.any(np.diag(situazione)==-1)):
        pass
    elif(np.any(np.diag(situazione)==1)):
        numV_x += 1
    elif(np.any(np.diag(situazione)==-1)):
        numV_o += 1

    #controlls reverse diag
    if(np.any(np.diag(np.fliplr(situazione))==1) and np.any(np.fliplr(situazione)==-1)):
        pass
    elif(np.any(np.fliplr(situazione)==1)):
        numV_x += 1
    elif(np.any(np.fliplr(situazione)==-1)):
        numV_o += 1
    


    return numV_x-numV_o
        


def minimax(situazione,row,col,diag,turn,depth,role):
    max,min = -100,100
    mossa = [0,0]
    mossa_rit = []
    if(controllo_vincita(turn,role,row,col,diag)):
        return 10 if role else -10,mossa
    elif(depth == 0 or not (0 in situazione)):
        return valuta_posizione(situazione),mossa
    
    if(role):
        for row_f,i in enumerate(situazione):
            for col_f,j in enumerate(i):
                if(j == 0):
                    situazione_copy = np.copy(situazione)
                    situazione_copy[row_f,col_f] = 1                    
                    minimax_child,mossa_rit = minimax(situazione_copy,np.sum(situazione_copy,axis=1),np.sum(situazione_copy,axis=0),np.array([np.sum(np.diag(situazione_copy)),np.sum(np.diag(np.fliplr(situazione_copy)))]),turn+1,depth-1,not role)
                    if(minimax_child > max):
                        max = minimax_child
                        mossa = [row_f,col_f]
        return max,mossa
                    
    else:
        for row_f,i in enumerate(situazione):
            for col_f,j in enumerate(i):
                if(j == 0):
                    situazione_copy = np.copy(situazione)
                    situazione_copy[row_f,col_f] = -1                    
                    minimax_child,mossa_rit = minimax(situazione_copy,np.sum(situazione_copy,axis=1),np.sum(situazione_copy,axis=0),np.array([np.sum(np.diag(situazione_copy)),np.sum(np.diag(np.fliplr(situazione_copy)))]),turn+1,depth-1,not role)
                    if(minimax_child < min):
                        min = minimax_child
                        mossa = [row_f,col_f]
        return min,mossa


row = np.array([1,-1,1])
col = np.array([0,0,1])
diag = np.array([-1,0])
situazione  = np.array( 
                        [[-1,1,1],
                        [1,-1,-1],
                        [0,0,1]]
                    )

ris = valuta_posizione(situazione)

print(minimax(situazione,row,col,diag,8,8,False))
