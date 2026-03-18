pipeline {
    agent any
   
   
    stages {
       
        stage('Clone Branch Main'){
            steps  {
              checkout scm
            }
        }
       
        stage('Docker Build and Deploy Production'){
            steps{
                 sh 'docker rm -f redex_backend_app &> /dev/null'
                 sh 'docker compose -f docker-compose.yml -p redex_backend_app up --build -d --force-recreate'
                //  sh 'docker exec  redex_backend_app sh -c "chmod 777 -R storage/ && chmod 777 -R public/"'
                 sh 'docker rmi $(docker images --filter "dangling=true" -q --no-trunc)'
            }
        }

        stage('Port Information'){
            steps{
                 echo "Port Backend: 6045"
            }
        }


        // stage('Docker push'){
        //      steps {
        //         withDockerRegistry([credentialsId: "docker-hub", url: "https://index.docker.io/v1/"]) {
        //             sh 'docker tag node_test hathanhhai/node_test:v1'
        //             sh "docker push hathanhhai/node_test:v1"
        //         }
        //     }
        // }




        // stage('Deploy to remote docker host') {
        //     steps {
                
        //         script {
        //             // sh 'docker pull hathanhhai/node_test:v1'
        //             // sh 'docker stop app_node || true'
        //             // sh 'docker rm app_node || true'
        //             // sh 'docker rmi -f hathanhhai/node_test:v1'
        //             // sh 'docker run -d -p 3000:3000 --name app_node node_test  '
        //         }
        //     }
        // }

        
    }
  
}
