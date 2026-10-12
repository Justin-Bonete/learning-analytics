import sys
import json
import numpy as np
from sklearn.tree import DecisionTreeClassifier


# ✅ Load input data from PHP
try:
    input_data = json.loads(sys.argv[1])
except Exception as e:
    print(f"Error loading input data: {e}")
    sys.exit(1)

# Extract scores and school info
try:
    scores_dict = {subject: float(score) for subject, score in input_data["scores"].items()}  # Convert scores to float
    accessibility = int(input_data["school_info"]["accessibility"])  # Map accessibility value
    facilities = int(input_data["school_info"]["facilities"])  # Map facilities value
    internet = int(input_data["school_info"]["internet"])  # Map internet connectivity value
    interventions_per_subject = input_data["interventions"]  # Interventions from PHP
    school_interventions = input_data.get("school_interventions", [])  # School interventions

except KeyError as e:
    print(f"Missing key in input data: {e}")
    sys.exit(1)
except ValueError as e:
    print(f"Error converting input data: {e}")
    sys.exit(1)


# Convert interventions into a mapping of subject to intervention descriptions
interventions_mapping = {}
for intervention in interventions_per_subject:
    if isinstance(intervention, dict):  # Ensure we're dealing with a dictionary
        interventions_mapping[intervention["subject"]] = intervention["intervention_description"]

# Go through each subject and check for intervention
interventions_per_subject = {}

for subject, score in scores_dict.items():
    score = float(score)  # Convert the score to float for accurate comparison
    intervention_found = "No intervention needed"  # Default value

    # Loop through the interventions to find the correct one for each subject
    for intervention in input_data["interventions"]:
        if isinstance(intervention, dict):  # Ensure we're dealing with a dictionary
            if intervention["subject"] == subject:
                score_range_start = float(intervention["score_range_start"])  # Convert to float
                score_range_end = float(intervention["score_range_end"])  # Convert to float

                # Check if the score falls within the range
                if score >= score_range_start and score <= score_range_end:
                    intervention_found = intervention["intervention_description"]
                    break  # Stop searching once the matching intervention is found

    interventions_per_subject[subject] = intervention_found  # Add to the dictionary

# Print the results to verify
print(f"Interventions per subject: {interventions_per_subject}")


# Extract features (scores and school conditions)
X = []
y = []

# Prepare input features for the Decision Tree (use scores and school conditions as input features)
for subject, score in scores_dict.items():
    X.append([score, accessibility, facilities, internet])
    
    # Find the intervention for this subject
    intervention_found = interventions_per_subject.get(subject, "No intervention needed")  # Default intervention
    y.append(intervention_found)  # Append the intervention (either found or default)

# Create a mapping of intervention descriptions to numerical labels
intervention_labels = list(set(y))
intervention_to_label = {desc: idx for idx, desc in enumerate(intervention_labels)}
label_to_intervention = {idx: desc for idx, desc in enumerate(intervention_labels)}

# Convert the target labels (interventions) to numerical labels
y_labels = np.array([intervention_to_label[desc] for desc in y])

X = np.array(X)

# Create and train a Decision Tree model
clf = DecisionTreeClassifier()
clf.fit(X, y_labels)

# Make predictions for each subject based on the model
predictions = clf.predict(X)

# Convert numerical predictions back to intervention descriptions
predicted_interventions = {subject: label_to_intervention[pred] for subject, pred in zip(scores_dict.keys(), predictions)}

# Identify subjects that need improvement with low mastery level
subjects_needing_improvement = {subject: score for subject, score in scores_dict.items() if score < 35}
subjects_good = {subject: score for subject, score in scores_dict.items() if score >= 35}

cause = ""  # Start empty to ensure proper override

if accessibility < 3 or facilities < 3 or internet < 3:
    if accessibility == 2:
        cause += "Limited school accessibility, which may occasionally hinder students from attending classes on time. "
    elif accessibility == 1:
        cause += "Severely restricted school accessibility, making it difficult for students to attend classes regularly. "

    if facilities == 2:
        cause += "Inadequate classroom facilities and learning materials, leading to a lack of essential resources for effective learning. "
    elif facilities == 1:
        cause += "Severely limited facilities and learning materials, significantly impacting students' ability to learn effectively. "

    if internet == 2:
        cause += "Unstable internet connectivity, restricting access to online learning tools and digital resources. "
    elif internet == 1:
        cause += "No internet connectivity, completely preventing access to online learning tools and digital resources. "

# If `cause` is still empty, set the default message
if not cause:
    cause = "No significant school-related issues detected."
    

# ✅ Prepare Training Data for Decision Tree (School Interventions)
X_train2 = []
y_train2 = []
intervention_map2 = {}
for entry2 in school_interventions:
    X_train2.append([entry2["accessibility_score"], entry2["facilities_score"], entry2["internetconnectivity_score"]])
    y_train2.append(entry2["id"])
    intervention_map2[entry2["id"]] = entry2["id"]

# Ensure there is training data before training Decision Tree for school interventions
if X_train2 and y_train2:
    X_train2 = np.array(X_train2)
    y_train2 = np.array(y_train2)
    clf_school2 = DecisionTreeClassifier()
    clf_school2.fit(X_train2, y_train2)
    school_input = np.array([[accessibility, facilities, internet]])
    predicted_intervention_id = clf_school2.predict(school_input)[0]
    predicted_intervention_desc = intervention_map2.get(predicted_intervention_id, "No intervention found")
else:
    predicted_intervention_desc = "No school interventions available."



# Format output for PHP
output = f"Subjects Needing Improvement: {subjects_needing_improvement} \n"
output += f"Subjects Good: {subjects_good} \n"
output += f"Identified Cause: {cause}\n"

output += f"\nGeneral Intervention: {predicted_intervention_desc}\n"

output += "Interventions Per Subject:\n"
for subject, intervention_text in predicted_interventions.items():
    output += f"- {subject.capitalize()}: {intervention_text}\n"

# Print the output, which can be passed back to PHP
print(output)  # Final output
